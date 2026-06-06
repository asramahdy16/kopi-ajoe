<x-manager-layout>
    <x-slot name="header">
        Approval Upah Seller
    </x-slot>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-start gap-3">
            <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-emerald-800 text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-red-800 text-sm font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-800">Daftar Upah Harian Seller</h3>
            <div class="flex gap-2">
                <span class="bg-amber-100 text-amber-700 text-xs font-bold px-2.5 py-1 rounded-full">
                    {{ $salaries->where('status', 'pending')->count() }} Pending
                </span>
                <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2.5 py-1 rounded-full">
                    {{ $salaries->where('status', 'approved')->count() }} Approved
                </span>
            </div>
        </div>
        
        <div class="p-0 overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold border-b border-slate-100">Tanggal Sesi</th>
                        <th class="px-6 py-4 font-semibold border-b border-slate-100">Seller</th>
                        <th class="px-6 py-4 font-semibold border-b border-slate-100 text-right">Penjualan</th>
                        <th class="px-6 py-4 font-semibold border-b border-slate-100 text-right">Rincian Upah</th>
                        <th class="px-6 py-4 font-semibold border-b border-slate-100 text-center">Status</th>
                        <th class="px-6 py-4 font-semibold border-b border-slate-100 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($salaries as $salary)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-medium text-slate-700">{{ \Carbon\Carbon::parse($salary->session->session_date)->format('d M Y') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center font-bold text-xs">
                                        {{ substr($salary->seller->name, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-slate-800">{{ $salary->seller->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="font-bold text-slate-700">Rp {{ number_format($salary->total_sales, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 text-right text-sm">
                                <div class="text-slate-500">Pokok: Rp {{ number_format($salary->base_salary, 0, ',', '.') }}</div>
                                <div class="text-slate-500">Komisi: Rp {{ number_format($salary->commission, 0, ',', '.') }}</div>
                                <div class="font-bold text-emerald-600 mt-1">Total: Rp {{ number_format($salary->total_salary, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($salary->status == 'pending')
                                    <span class="inline-flex px-2.5 py-1 rounded-md bg-amber-100 text-amber-700 text-xs font-bold uppercase tracking-wider">Pending</span>
                                @elseif($salary->status == 'approved')
                                    <span class="inline-flex px-2.5 py-1 rounded-md bg-cyan-100 text-cyan-700 text-xs font-bold uppercase tracking-wider">Approved</span>
                                @else
                                    <span class="inline-flex px-2.5 py-1 rounded-md bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-wider">Paid</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($salary->status == 'pending')
                                    <form action="{{ route('manager.salaries.approve', $salary) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Setujui pembayaran upah ini?')" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-xs font-bold shadow-sm transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Approve
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400 italic">Disetujui</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p>Belum ada data upah yang tercatat.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-manager-layout>
