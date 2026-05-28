<?php

namespace Database\Factories;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    protected $model = Loan::class;
    public function definition(): array
    {
        $loanDate = fake()->dateTimeBetween('-60 days', 'now');
        $dueDate = (clone $loanDate)->modify('+14 days');
        $isReturned = fake()->boolean(30);
        $returnedDate = $isReturned
            ? fake()->dateTimeBetween($loanDate, 'now')
            : null;
        $status = $isReturned
            ? 'returned'
            : ($dueDate < now() ? 'overdue' : 'active');
        return [
            'book_id' => null, // Asignado en el seeder
            'member_id' => null, // Asignado en el seeder
            'loaned_by' => null, // Asignado en el seeder
            'loan_date' => $loanDate,
            'due_date' => $dueDate,
            'returned_date' => $returnedDate,
            'status' => $status,
            'notes' => fake()->optional(0.3)->sentence(),
        ];
    }
}
