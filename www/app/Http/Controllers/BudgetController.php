<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function getBudgets() {
        return view('budgets');
    }

    public function getBudgetBuilder() {
        return view('budget-builder');
    }
}
