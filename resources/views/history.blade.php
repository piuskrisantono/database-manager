@extends('layouts.master')

@section('content')





<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">History Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>
          </p>
        </div>
      </div>
    </div>
  </div>




<div class="py-4" style="margin: auto">

        <div class="d-flex justify-content-between mx-3 px-3 shadow-sm py-0 content-box" style="background-color: white; height: 50px; margin-bottom: 10px;">
                <div class="title-tab my-auto" style="font-size: 20px; overflow:hidden">
                    History
                </div>
        </div>

        <div class="content-box p-auto shadow-sm mx-3">
                <table class="table" style="border-bottom: 1px lightgrey solid; font-size: 14px;">
                        <tbody>
                            @if($histories[0] == null)
                                <tr><td colspan=4 style="text-align: center;">There is no activity</td></tr>
                            @else
                              @foreach($histories as $history)

                                    <tr>
                                        <td style="width: 150px;">{{$history->created_at}}</td>
                                        @if($history->user)
                                            <td style="width: 50px"><div  style="height: 30px; width:30px; border-radius: 4vw;background-repeat: no-repeat; display: inline-block; background-image: url({{ asset('img/avatar/'.$history->user->avatar.'.png') }}); background-position: center; background-size: 100%; border: 2px solid lightgrey; background-color:#ecf0f1;"></div></td>
                                        @else
                                        <td style="width: 50px"><div  style="height: 30px; width:30px; border-radius: 4vw;background-repeat: no-repeat; display: inline-block; background-image: url({{ asset('img/avatar/5.png') }}); background-position: center; background-size: 100%; border: 2px solid lightgrey; background-color:#ecf0f1;"></div></td>
                                        @endif
                                        <td><b>{{$history->actor}}</b> {{$history->activity}} {{$history->object}}</b></td>
                                        <td class="p-0">
                                        @if($history->description != "")
                                        <button class=" btn btn-primary float-right" onclick="changePopup('{{$history->description}}')" data-toggle="modal" data-target="#exampleModalCenter">Details</button>
                                        @endif
                                        </td>
                                    </tr>
                              @endforeach


                            @endif
                        </tbody>
                      </table>
                <div class="d-flex flex-row-reverse px-3" style="max-height: 50px;">
                        {{ $histories->links() }}
                </div>
        </div>



</div>
@endsection

<script type="text/javascript">

function changePopup(content){
    $('.modal-body p').text(content);
}

</script>
