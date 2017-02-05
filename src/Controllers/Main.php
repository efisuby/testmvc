<?php

namespace App\Controllers;

use App\Core\HandleResult;
use App\Core\HttpRequest;
use App\Models\Model;
use App\Models\Todo;

class Main extends Controller
{
    public function indexAction(HttpRequest $request)
    {
    }

    /**
     * @inheritDoc
     */
    public function postHandleRequest(HttpRequest $request, HandleResult $result)
    {
        $rawOrderList = $request->getRequestVar('order');
        $orderList = [];
        foreach ($rawOrderList as $field => $direction) {
            $orderList[Todo::parseField($field)] = Todo::parseOrder($direction);
        }
        $result->setVar('todoList', Todo::getListByCondition([], $orderList));

        $availableOrderList = [
            'name' => Model::ORDER_ASC,
            'email' => Model::ORDER_ASC,
            'finished' => Model::ORDER_ASC,
        ];

        $orderList = [];
        $selectedOrderList = [];
        foreach ($rawOrderList as $field => $direction) {
            $orderList[Todo::parseField($field)] = Todo::parseOrder($direction);
            $availableOrderList[Todo::parseField($field)] = Todo::parseOrder($direction);
            $selectedOrderList[$field] = true;
        }

        $result->setVar('todoList', Todo::getListByCondition([], $orderList));
        $result->setVar('orderList', $availableOrderList);
        $result->setVar('selectedOrder', $selectedOrderList);

        return parent::postHandleRequest($request, $result); // TODO: Change the autogenerated stub
    }
}