<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        User::factory()->create([
            'name' => 'teste',
            'email' => 'teste@teste.com',
            'password' => 'password',
        ]);

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price')->default(0);
            $table->string('variations')->nullable();
            $table->timestamps();
        });   

        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->integer('quantity')->default(0);
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('pending');
            $table->integer('freight')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('total')->default(0);
            $table->string('email');
            $table->string('zipcode')->nullable();
            $table->string('address')->nullable();
            $table->string('address_number')->nullable();
            $table->string('address_complement')->nullable();
            $table->string('address_district')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_state')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->integer('quantity')->default(0);
            $table->integer('price')->default(0);
            $table->timestamps();
        });

        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('enable');
            $table->string('code');
            $table->string('type')->default('fixed');            
            $table->decimal('value', 10, 2)->nullable();             
            $table->dateTime('starts_at');
            $table->dateTime('expires_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
        Schema::dropIfExists('products');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('coupons');
    }
};
