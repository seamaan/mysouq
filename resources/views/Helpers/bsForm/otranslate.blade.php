   <?php
   foreach (App\Lang::all() as $key => $lang){
      $langForm = new langForm($lang->id);
      //dd($langForm);
       call_user_func_array($callback, [$langForm,$lang->code]);
   }
