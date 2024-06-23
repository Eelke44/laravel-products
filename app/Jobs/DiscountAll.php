<?php

namespace App\Jobs;

use App\Repositories\PlainSqlProductRepository;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Job that discounts all products.
 */
class DiscountAll implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ProductRepositoryInterface $repository;
    private float $percentage;

    /**
     * Create a new discount all job with a given discount percentage.
     */
    public function __construct(ProductRepositoryInterface $repository, float $percentage)
    {
        $this->repository = $repository;
        $this->percentage = $percentage;
        $this->onQueue('products');
    }

    /**
     * Execute the discount all job.
     */
    public function handle(): void
    {
        $success = $this->repository->multiplyAllPricesBy(1 - 0.01*$this->percentage);
    }
}
