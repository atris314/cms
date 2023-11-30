<?php

namespace App\Repositories;

use App\Models\Nextpayment;
use App\Models\Order;
use App\Models\Ordernextpay;
use App\Models\Payment;

class OrderRepository implements OrderRepositoryInterface
{
    // model property on class instances
    protected $model;

    protected $nextpayment;

    // Constructor to bind model to repo
    public function __construct(Ordernextpay $model, Nextpayment $nextpayment)
    {
        $this->model = $model;
        $this->nextpayment = $nextpayment;
    }

    // Get all instances of model
    public function all()
    {
        return $this->model->all();
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->model->create([
            'api_key' => $data['api_key'],
            'sandbox' => $data['sandbox'],
            'payer_name' => $data['name'],
            'customer_phone' => $data['phone'],
            'amount' => $data['amount'],
            'callback_uri' => $data['callback'],
            'payer_desc' => $data['desc'],
            'status' => 'processing',
        ]);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->find($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    // show the record with the given id
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function createPayment(array $data, $id)
    {
        return $this->model->findOrFail($id)->payments()->create($data);
    }
}
