<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';

    protected $fillable = [
        'transaksi_id',
        'order_id',
        'transaction_id',
        'gross_amount',
        'payment_type',
        'bank',
        'va_number',
        'transaction_status',
        'fraud_status',
        'transaction_time',
        'settlement_time',
        'payment_url',
        'midtrans_response',
        'notes',
    ];

    protected $casts = [
        'gross_amount' => 'decimal:2',
        'transaction_time' => 'datetime',
        'settlement_time' => 'datetime',
        'midtrans_response' => 'array',
    ];

    /**
     * Relasi ke Pesanan
     */
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'transaksi_id');
    }

    /**
     * Check if successful
     */
    public function isSuccess(): bool
    {
        return in_array($this->transaction_status, ['settlement', 'capture']);
    }

    /**
     * Check if pending
     */
    public function isPending(): bool
    {
        return $this->transaction_status === 'pending';
    }

    /**
     * Check if failed
     */
    public function isFailed(): bool
    {
        return in_array($this->transaction_status, ['deny', 'cancel', 'expire', 'failure']);
    }

    /**
     * Get status label
     */
    public function getStatusLabel(): string
    {
        $labels = [
            'pending' => 'Menunggu Pembayaran',
            'settlement' => 'Pembayaran Berhasil',
            'capture' => 'Pembayaran Berhasil',
            'deny' => 'Pembayaran Ditolak',
            'expire' => 'Pembayaran Kadaluarsa',
            'cancel' => 'Pembayaran Dibatalkan',
            'failure' => 'Pembayaran Gagal',
        ];

        return $labels[$this->transaction_status] ?? 'Status Tidak Diketahui';
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClass(): string
    {
        $classes = [
            'pending' => 'warning',
            'settlement' => 'success',
            'capture' => 'success',
            'deny' => 'danger',
            'expire' => 'secondary',
            'cancel' => 'danger',
            'failure' => 'danger',
        ];

        return $classes[$this->transaction_status] ?? 'secondary';
    }

    /**
     * Get payment method label
     */
    public function getPaymentMethodLabel(): string
    {
        if (!$this->payment_type) {
            return '-';
        }

        $labels = [
            'credit_card' => 'Kartu Kredit',
            'bank_transfer' => strtoupper($this->bank ?? '') . ' Virtual Account',
            'echannel' => 'Mandiri Bill',
            'gopay' => 'GoPay',
            'qris' => 'QRIS',
            'shopeepay' => 'ShopeePay',
            'other' => 'Lainnya',
        ];

        return $labels[$this->payment_type] ?? ucfirst($this->payment_type);
    }
}