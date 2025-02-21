<?php

namespace App\Livewire\Transactions;

use App\Models\FinancialTransaction;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardTransaction extends Component
{
    public User $user;

    public float $averageTicket = 0;

    public float $totalAmountDay = 0;

    public float $salesCashInflow = 0;

    public array $paymentMethodDetails = [];

    public array $detailReceivables = [];

    public string $date;

    public string $year;

    protected $queryString = ['date', 'year'];

    public function mount()
    {
        $this->user = Auth::user();
        $this->date = request()->query('date', now()->format('Y-m-d'));
        $this->year = request()->query('year', now()->year);
    }

    public function render()
    {
        $orders = Order::select('final_amount', 'payment_method')
            ->where('store_id', $this->user->store_id)
            ->where('created_at', '>', $this->date)
            ->where('created_at', '<=', "$this->date 23:59:59")
            ->get();

        $this->salesCashInflow = FinancialTransaction::where('type', "receivable")
            ->where('store_id', $this->user->store_id)
            ->where('payment_completed_at', '>', $this->date)
            ->where('payment_completed_at', '<=', "$this->date 23:59:59")
            ->sum('paid_amount');

        $countOrders = $orders->count() > 0 ? $orders->count() : 1;

        $this->totalAmountDay  = $orders->sum('final_amount');
        $this->averageTicket   = round($this->totalAmountDay / $countOrders, 2);
        $this->salesCashInflow = round($this->salesCashInflow, 2);

        $this->buildPaymentMethodDetails($orders);

        $financialTransactions = FinancialTransaction::select(
            'payment_estimate_at',
            'payment_completed_at',
            'gross_amount',
            'paid_amount',
            'net_amount',
        )
            ->where('type', "receivable")
            ->where('store_id', $this->user->store_id)
            ->where('payment_estimate_at', '>', "$this->year-01-01")
            ->where('payment_estimate_at', '<=', "$this->year-12-31 23:59:59")
            ->get();

        $this->detailReceivables = [];

        foreach (range(1, 12) as $month) {
            $grossAmount = $this->sumTransactionByMonth($financialTransactions, $month, 'payment_estimate_at', 'gross_amount');
            $netAmount   = $this->sumTransactionByMonth($financialTransactions, $month, 'payment_estimate_at', 'net_amount');
            $paidAmount  = $this->sumTransactionByMonth($financialTransactions, $month, 'payment_completed_at', 'paid_amount');

            $this->detailReceivables[] = [
                'month'        => $month . "/" . $this->year,
                'gross_amount' => $grossAmount,
                'net_amount'   => $netAmount,
                'paid_amount'  => $paidAmount,
            ];
        }

        return view('livewire.transactions.dashboard-transaction');
    }

    public function buildPaymentMethodDetails($orders)
    {
        $this->paymentMethodDetails = [
            [
                'payment_method' => 'PIX',
                'gross_amount'   => $orders->where('payment_method', 'pix')->sum('final_amount'),
            ],
            [
                'payment_method' => 'Cartão de Crédito',
                'gross_amount'   => $orders->where('payment_method', 'credit_card')->sum('final_amount'),
            ],
            [
                'payment_method' => 'Dinheiro',
                'gross_amount'   => $orders->where('payment_method', 'cash')->sum('final_amount'),
            ],
            [
                'payment_method' => 'Transferência Bancária',
                'gross_amount'   => $orders->where('payment_method', 'bank_transfer')->sum('final_amount'),
            ],
            [
                'payment_method' => 'Boleto',
                'gross_amount'   => $orders->where('payment_method', 'bank_slip')->sum('final_amount'),
            ],
        ];
    }

    public function sumTransactionByMonth($financialTransaction, string $month, string $filterField, string $sumFiled)
    {
        $startDate = Carbon::create($this->year, $month, 1)->format('Y-m-d');
        $endDate   = Carbon::create($this->year, $month, 1)->endOfMonth()->format('Y-m-d');

        return $financialTransaction->where($filterField, '>', $startDate)
            ->where($filterField, '<=', "$endDate 23:59:59")
            ->sum($sumFiled);
    }

    public function renderd()
    {
        return view('livewire.transactions.dashboard-transaction');
    }
}
