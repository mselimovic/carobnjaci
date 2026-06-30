<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Product;
use App\Models\Shop;
use App\Notifications\MessageReceivedNotification;
use App\Support\MarketplacePresenter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Messages/Index', [
            'threads' => MarketplacePresenter::inboxThreadsProps($request->user()),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'shop_id' => ['required', 'integer', 'exists:shops,id'],
            'product_id' => ['nullable', 'integer', 'exists:products,id'],
            'subject' => ['required', 'string', 'max:180'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        $shop = Shop::query()->with('user')->findOrFail($validated['shop_id']);
        $product = isset($validated['product_id'])
            ? Product::query()->whereKey($validated['product_id'])->where('shop_id', $shop->id)->first()
            : null;

        abort_if($shop->user_id === $request->user()->id, 403);
        abort_if($shop->user?->is_admin, 403);

        $message = Message::query()->create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $shop->user_id,
            'product_id' => $product?->id,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'awaiting_seller',
        ]);

        $message->loadMissing(['sender', 'product']);
        $shop->user?->notify(new MessageReceivedNotification(
            $message,
            $shop->user?->is_admin ? "/creator/messages/{$message->id}" : "/creator/messages/{$message->id}",
        ));

        return redirect()->back()->with('success', __('ui.contact.success'));
    }

    public function show(Request $request, Message $message)
    {
        abort_unless($this->canView($request->user()->id, $message, $request->user()->is_admin), 403);

        Message::query()
            ->where(fn ($query) => MarketplacePresenter::applyConversationScope($query, $message))
            ->where('receiver_id', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return Inertia::render('Creator/MessageShow', [
            'message' => MarketplacePresenter::creatorMessageDetail($message, $request->user()),
        ]);
    }

    public function showPublic(Request $request, Message $message)
    {
        abort_unless($this->canView($request->user()->id, $message, $request->user()->is_admin), 403);

        Message::query()
            ->where(fn ($query) => MarketplacePresenter::applyConversationScope($query, $message))
            ->where('receiver_id', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return Inertia::render('Messages/Show', [
            'message' => MarketplacePresenter::creatorMessageDetail($message, $request->user()),
        ]);
    }

    public function reply(Request $request, Message $message): RedirectResponse
    {
        abort_unless($this->canView($request->user()->id, $message, $request->user()->is_admin), 403);

        $validated = $request->validate([
            'message' => ['required', 'string', 'min:2', 'max:2000'],
        ]);

        $recipientId = $message->sender_id === $request->user()->id
            ? $message->receiver_id
            : $message->sender_id;

        $reply = Message::query()->create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $recipientId,
            'product_id' => $message->product_id,
            'subject' => $message->subject,
            'message' => $validated['message'],
            'status' => $message->sender_id === $request->user()->id ? 'awaiting_seller' : 'awaiting_buyer',
        ]);

        Message::query()
            ->where(fn ($query) => MarketplacePresenter::applyConversationScope($query, $message))
            ->update(['status' => $reply->status]);

        $reply->loadMissing(['sender', 'receiver', 'product']);
        $reply->receiver?->notify(new MessageReceivedNotification(
            $reply,
            $reply->receiver?->is_admin || $this->isCreatorSideRecipient($reply) ? "/creator/messages/{$message->id}" : "/messages/{$message->id}",
        ));

        return redirect()->back()->with('success', __('ui.creator.reply_success'));
    }

    public function close(Request $request, Message $message): RedirectResponse
    {
        abort_unless($this->canView($request->user()->id, $message, $request->user()->is_admin), 403);

        Message::query()
            ->where(fn ($query) => MarketplacePresenter::applyConversationScope($query, $message))
            ->update(['status' => 'closed']);

        return redirect()->back()->with('success', __('ui.creator.close_success'));
    }

    protected function canView(int $userId, Message $message, bool $isAdmin): bool
    {
        return $isAdmin || $message->receiver_id === $userId || $message->sender_id === $userId;
    }

    protected function isCreatorSideRecipient(Message $message): bool
    {
        return (bool) ($message->receiver?->shop()->exists() || $message->receiver?->is_admin);
    }
}
