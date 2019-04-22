<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">{{$model->name}}</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3 col-lg-3 " align="center"> <img alt="{{$model->name}}" src="{{$image}}" class="img-responsive"> </div>
            <div class=" col-md-9 col-lg-9 ">
                <table class="table table-user-information">
                    <tbody>
                    <tr>
                        <td>{{$model->name}}</td>
                    </tr>
                 <tr>
                     <td>{{$model->content}}</td>
                 </tr>
                    <tr>
                        <td>{{$model->created_at}}</td>
                    </tr>


                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>