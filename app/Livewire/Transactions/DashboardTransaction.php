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
        $orders = Order::select('amount_received', 'payment_method')
            ->where('store_id', $this->user->store_id)
            ->where('created_at', '>', $this->date)
            ->where('created_at', '<=', "$this->date 23:59:59")
            ->get();

        $this->salesCashInflow = FinancialTransaction::where('type', "receivable")
            ->where('store_id', $this->user->store_id)
            ->where('payment_completed_at', '>', $this->date)
            ->where('payment_completed_at', '<=', "$this->date 23:59:59")
            ->sum('amount_paid');

        $this->totalAmountDay  = round($orders->sum('amount_received'), 2);
        $this->averageTicket   = round($this->totalAmountDay / ($orders->count() + 1), 2);
        $this->salesCashInflow = round($this->salesCashInflow, 2);

        $this->buildPaymentMethodDetails($orders);

        $financialTransactions = FinancialTransaction::select(
            'payment_estimate_at',
            'payment_completed_at',
            'amount',
            'amount_paid'
        )
            ->where('type', "receivable")
            ->where('store_id', $this->user->store_id)
            ->where('payment_estimate_at', '>', "$this->year-01-01")
            ->where('payment_estimate_at', '<=', "$this->year-12-31 23:59:59")
            ->get();

        $this->detailReceivables = [];

        foreach (range(1, 12) as $month) {
            $amount     = $this->sumTransactionByMonth($financialTransactions, $month, 'payment_estimate_at', 'amount');
            $amountPaid = $this->sumTransactionByMonth($financialTransactions, $month, 'payment_completed_at', 'amount_paid');

            $this->detailReceivables[] = [
                'month'          => $month . "/" . $this->year,
                'amount'         => $amount,
                'amount_paid'    => $amountPaid,
                'amount_receive' => $amount - $amountPaid,
            ];
        }

        return view('livewire.transactions.dashboard-transaction');
    }

    public function buildPaymentMethodDetails($orders)
    {
        $this->paymentMethodDetails = [
            [
                'payment_method' => 'PIX',
                'total'          => $orders->where('payment_method', 'pix')->sum('amount_received'),
            ],
            [
                'payment_method' => 'Cartão de Crédito',
                'total'          => $orders->where('payment_method', 'credit_card')->sum('amount_received'),
            ],
            [
                'payment_method' => 'Dinheiro',
                'total'          => $orders->where('payment_method', 'cash')->sum('amount_received'),
            ],
            [
                'payment_method' => 'Transferência Bancária',
                'total'          => $orders->where('payment_method', 'bank_transfer')->sum('amount_received'),
            ],
            [
                'payment_method' => 'Boleto',
                'total'          => $orders->where('payment_method', 'bank_slip')->sum('amount_received'),
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
