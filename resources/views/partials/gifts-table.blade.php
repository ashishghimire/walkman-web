<h2>Unresolved Gifts</h2>
<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Winner Name</th>
            <th>Gift</th>
            <th>Voucher Code</th>
            <th>Resolve</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1?>
        @forelse($user->availableGifts as $gift)
            <tr>
                <td>{{$i}}</td>
                <td>{{$gift->winner->fb_info['name']}}</td>
                <td>{{$gift->incentive->description}}</td>
                <td>{{$gift->voucher_code}}</td>
                <td>
                    <button type="button" class="btn btn-info">Resolve</button>
                </td>
            </tr>
            <?php $i++?>
        @empty
        @endforelse

        </tbody>
    </table>
</div>