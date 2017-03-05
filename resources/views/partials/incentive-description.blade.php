<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{$incentive->description}}</h4>
            </div>
            <div class="modal-body">
                <p>Distribution day: {{ucfirst($incentive->day)}}</p>
                <p>Gold Value: {{$incentive->gold_value}}</p>
                @if(!empty($incentive->photo))
                    <p>
                        <img src="{{url($incentive->photo)}}" height="300" width="400">
                    </p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>