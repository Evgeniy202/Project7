<div class="col-12">
    @if(!empty($status))
        <h4 class="mb-5">{{$status}} Orders:</h4>
    @else
    <h4 class="mb-5">Orders:</h4>
    @endif
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" role="tabpanel"
             aria-labelledby="list-orders-list">
            <table class="table table-striped text-dark">
                <thead>
                <tr>
                    <th class="col-md-2">Number</th>
                    <th class="col-md-2">Status</th>
                    <th class="col-md-2">Price</th>
                    <th class="col-md-2">Created at</th>
                    <th class="col-md-2">Updated at</th>
                </tr>
                </thead>
                <tbody class="text-dark">
                @foreach($ordersList as $order)
                    <tr>
                        <td class="col-md-2">№{{ $order->id }}</td>
                        <td class="col-md-2">{{ $order->status }}</td>
                        <td class="col-md-2">${{ $order->price }}</td>
                        <td class="col-md-2">{{$order->created_at}}</td>
                        <td class="col-md-2">{{$order->updated_at}}</td>
                        <td>
                            <a href="{{ route('order-detail', $order->id) }}"
                               class="btn btn-primary" target="_blank">More</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<footer class="d-flex mt-4 align-items-center">
    @if (!empty($ordersList[0]))
        {{ $ordersList->links() }}
    @endif
</footer>
