<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\User;
use App\Support\AdminActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::query()->orderBy('sort_order')->orderBy('id')->paginate(10);

        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $faq = Faq::create([
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        $admin = Auth::user();
        if ($admin instanceof User) {
            AdminActivityLogger::log(
                admin: $admin,
                action: 'faq_created',
                targetType: 'faq',
                targetId: $faq->id,
                description: 'Admin menambahkan FAQ baru: '.$faq->question,
                meta: ['is_active' => $faq->is_active, 'sort_order' => $faq->sort_order],
            );
        }

        return redirect()->route('admin.faqs.index')->with('status', 'FAQ berhasil ditambahkan.');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $original = $faq->getOriginal();

        $faq->update([
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        $admin = Auth::user();
        if ($admin instanceof User) {
            AdminActivityLogger::log(
                admin: $admin,
                action: 'faq_updated',
                targetType: 'faq',
                targetId: $faq->id,
                description: 'Admin memperbarui FAQ: '.$faq->question,
                meta: [
                    'before' => [
                        'question' => $original['question'] ?? null,
                        'sort_order' => $original['sort_order'] ?? null,
                        'is_active' => (bool) ($original['is_active'] ?? false),
                    ],
                    'after' => [
                        'question' => $faq->question,
                        'sort_order' => $faq->sort_order,
                        'is_active' => $faq->is_active,
                    ],
                ],
            );
        }

        return redirect()->route('admin.faqs.index')->with('status', 'FAQ berhasil diperbarui.');
    }

    public function destroy(Faq $faq)
    {
        $question = $faq->question;
        $faqId = $faq->id;
        $faq->delete();

        $admin = Auth::user();
        if ($admin instanceof User) {
            AdminActivityLogger::log(
                admin: $admin,
                action: 'faq_deleted',
                targetType: 'faq',
                targetId: $faqId,
                description: 'Admin menghapus FAQ: '.$question,
            );
        }

        return redirect()->route('admin.faqs.index')->with('status', 'FAQ berhasil dihapus.');
    }
}
