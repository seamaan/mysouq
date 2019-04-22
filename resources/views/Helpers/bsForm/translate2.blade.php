<div class="box">
   <div class="box-body">
      @foreach (App\Lang::all() as $key => $lang)
           <?php
           $langForm = new langForm($lang->id);
           //dd($langForm);
           call_user_func_array($callback, [$langForm,$lang->code]);
           ?>
           <label for="inputtext" class="col-sm-2 control-label">
              <img src="{{ flug($lang->code) }}"> {{ $lang->name }}</a>
           </label>
      @endforeach
   </div>
</div>
