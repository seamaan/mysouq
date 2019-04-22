<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class View extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:view {name} {path=null}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command Used To Set Recource Views Files With Data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->viewIndex();
        $this->viewCreate();
        $this->viewEdit();
        $this->viewShow();
    }
    public function createPath($path=null)
    {
        if (!is_null($path))
        {
            $path = str_replace('\\', '/', $path);
            $pathArray = explode('/', $path);

            $d ='';
            $paths = [];
            foreach ($pathArray as $key => $dir) {
                $d .= $key == 0 ? $dir : '/'.$dir;
                $paths[] = $d;
            }
            foreach ($paths as $folder)
            {
                if (!is_dir($folder))
                {
                    @mkdir($folder);
                }
            }
        }
    }

    public function viewIndex()
    {
        $prefix = last(explode('\\',str_singular($this->argument('name'))));
        $prefixspath = str_plural(snake_case($this->argument('name')));
        $prefixs = last(explode('\\',str_plural($this->argument('name'))));

//dd( $this->info($prefixs));

        if ($this->argument('path') == 'null')
        {
            $path = base_path('resources/views').'/'.$prefixspath;
        }else{

            $path = base_path('resources/views').'/'.$this->argument('path').'/'.$prefixspath;

        }
        if (!is_dir($path))
        {
            $this->createPath($path);
            $this->info('Folder ('.$prefixspath.') Was Created Successfuly.');
        }else{
            $this->error('Folder ('.$prefixspath.') already Exist!');
        }

        $data='
@extends(\'cpanel.index\')
@section(\'title\') {{ trans(\'lang.'.$prefixs.'\') }}  @endsection
@section(\'menu\') {!! getBreadcrumbs(\''.$prefix.'\')->index !!} @endsection

@section(\'content\')
    <div class="box">
        <div class="box-header">
            <div class="box-header">
                <h3 class="box-title">{{trans(\'lang.manage\',[\'var\'=>trans(\'lang.'.$prefixs.'\')])}}</h3>

                <div class="pull-right">
                    {!! Btn::create() !!}
                    {!! Btn::deleteAll(\''.$prefixs.'\') !!}
                </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
             <table id="mytable"  class="row-border stripe  table-border hover" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="checkall" class="css-checkbox" name="checkall">
                            <label for="checkall" name="checkbox2_lbl" class="css-label lite-red-check"></label>
                        </th>
                        <th>{{trans(\'lang.name\')}}</th>
                        <th>{{trans(\'lang.control\')}}</th>
                    </tr>
                    </thead>
                </table>
        </div>
        <!-- /.box-body -->
    </div>
@endsection
 @section(\'js\')
  <script>
                    $(document).ready(function() {
                        var table =$(\'#mytable\').DataTable( {
                            processing: true,
                            serverSide: true,
                            pageLength:50,
                             "ajax":"{{url(\'cpanel/'.$prefix.'/getdata\')}}",
                            columns: [
                                {data: \'checkbox\',
                                    name: \'\',
                                    searchable:false,
                                    orderable:false,
                                    exportable:false,
                                    printable:false,

                                },
                                {data: \'name\', name: \'name\'},
                                {data: \'control\', name: \'\',
                                    searchable:false,
                                    orderable:false,
                                    exportable:false,
                                    printable:false,

                                }
                            ],
                            "language": {
                                "url": \'{{url("/public/cpanel/cus/Arabic.json")}}\'
                            },

                            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
                            dom: \'Bfrtip\',
                            buttons: [
                                {
                                    extend:\'excelHtml5\',
                                    \'text\':\' <i class="fa fa-file-excel-o"></i> {{trans(\'lang.excel\')}}\',
                                    className: \'green\',
                                    exportOptions: {
                                        columns: [  1, 2,3 ]
                                    }

                                },
                                {
                                    extend:\'copyHtml5\',
                                    \'exportOptions\': {\'columns\': \':visible\'},
                                    \'text\':\' <i class="fa fa-copy"></i> {{trans(\'lang.copy\')}}\',
                                    className: \'orang\',
                                    exportOptions: {
                                        columns: [  1, 2,3 ]
                                    }


                                },
                                {
                                    \'extend\': \'pageLength\',
                                    \'fade\':false,
                                },




                            ]
                        } );

                    });
                </script>
 @endsection
';

        if (!file_exists($path.'/index.blade.php'))
        {
            $file = fopen($path.'/index.blade.php', "w");
            fwrite($file, $data);
            fclose($file);
            $this->info('File (index.blade.php) Was Created Successfuly.');
        }else{
            $this->error('File (index.blade.php) already Exist!');
        }
    }

    public function viewCreate()
    {
        $prefix = last(explode('\\',str_singular($this->argument('name'))));
        $prefixspath = str_plural(snake_case($this->argument('name')));
        $prefixs = last(explode('\\',str_plural($this->argument('name'))));

        if ($this->argument('path') == 'null')
        {
            $path = base_path('resources/views').'/'.$prefixspath;
        }else{

            $path = base_path('resources/views').'/'.$this->argument('path').'/'.$prefixspath;

        }
        $data='@extends(\'cpanel.index\')
        @section(\'title\'){{trans(\'lang.add\',[\'var\'=>trans(\'lang.'.$prefix.'\')])}}@endsection
        @section(\'menu\') {!! getBreadcrumbs(\''.$prefix.'\')->create !!} @endsection
        
        @section(\'content\')
        
            {!! bsForm::open([\'title\'=>trans(\'lang.add\',[\'var\'=>trans(\'lang.'.str_singular(snake_case($this->argument('name'))).'\')]),\'route\'=>\''.str_plural(snake_case($this->argument('name'))).'.store\',\'files\'=>true]) !!}
              {!! bsForm::translate(function($form){
                 $form->text(\'name\');
                 $form->textarea(\'content\',\'\',[\'class\'=>\'form-control editor\',\'id\'=>\'ckview\',]);}) 
             !!}
            {!! bsForm::image(\''.$prefix.'\') !!}
            {!! bsForm::close([\'submit\'=>true,\'reset\'=>true])!!}
        @endsection

        ';

        if (!file_exists($path.'/create.blade.php'))
        {
            $file = fopen($path.'/create.blade.php', "w");
            fwrite($file, $data);
            fclose($file);
            $this->info('File (create.blade.php) Was Created Successfuly.');
        }else{
            $this->error('File (create.blade.php) already Exist!');
        }
    }

    public function viewEdit()
    {
        $prefix = last(explode('\\',str_singular($this->argument('name'))));
        $prefixspath = str_plural(snake_case($this->argument('name')));
        $prefixs = last(explode('\\',str_plural($this->argument('name'))));
        if ($this->argument('path') == 'null')
        {
            $path = base_path('resources/views').'/'.str_plural(snake_case($this->argument('name')));
        }else{
            $path = base_path('resources/views').'/'.$this->argument('path').'/'.$prefixspath;
        }

        $data = '
        <?php
        $img=App\\'.str_singular(snake_case($this->argument('name'))).'::find($'.str_singular(snake_case($this->argument('name'))).'->id)->image();
        ?>
        @extends(\'cpanel.index\')
@section(\'title\')
    {{trans(\'lang.update\',[\'var\'=>$'.str_singular(snake_case($this->argument('name'))).'->name])}}
@stop
@section(\'menu\') {!! getBreadcrumbs(\''.str_singular(snake_case($this->argument('name'))).'\',$'.str_singular(snake_case($this->argument('name'))).'->id)->edit !!}  @endsection

@section(\'content\')

    {!! bsForm::open([\'title\'=>trans(\'lang.update\',[\'var\'=>$'.str_singular(snake_case($this->argument('name'))).'->name]),\'route\'=>[\''.str_plural(snake_case($this->argument('name'))).'.update\',$'.str_singular(snake_case($this->argument('name'))).'->id],\'method\'=>\'put\',\'files\'=>true]) !!}
    {!! bsForm::translate(function($form,$lang) use($'.$prefix.'){
            $form->text(\'name\',$'.$prefix.'->trans(\'name\',$lang));
            })
    !!}
    {!! bsForm::image(\''.$prefixs.'\',$'.$prefix.'->id) !!}

    {!! bsForm::close([\'submit\'=>true,\'reset\'=>true])!!}

@endsection';
        if (!file_exists($path.'/edit.blade.php'))
        {
            $file = fopen($path.'/edit.blade.php', "w");
            fwrite($file, $data);
            fclose($file);
            $this->info('File (edit.blade.php) Was Created Successfuly.');
        }else{
            $this->error('File (edit.blade.php) already Exist!');
        }
    }

    public function viewShow()
    {
        if ($this->argument('path') == 'null')
        {
            $path = base_path('resources/views').'/'.str_plural(snake_case($this->argument('name')));
        }else{

            $path = base_path('resources/views').'/'.$this->argument('path').'/'.str_plural(snake_case($this->argument('name')));

        }

        $data =  '@extends(\'cpanel.home\')
@section(\'title\') {{ trans(\'lang.'.str_plural(snake_case($this->argument('name'))).'\') }}  @endsection
@section(\'menu\') {!! getBreadcrumbs(\''.str_singular(snake_case($this->argument('name'))).'\',$'.str_singular(snake_case($this->argument('name'))).'->id)->show !!}  @endsection
@section(\'content\')

<div class="note note-info">
    <p>{!! $'.str_singular(snake_case($this->argument('name'))).'->trans(\'info\') !!}</p>
</div>
 
@endsection';
        if (!file_exists($path.'/show.blade.php'))
        {
            $file = fopen($path.'/show.blade.php', "w");
            fwrite($file, $data);
            fclose($file);
            $this->info('File (show.blade.php) Was Created Successfuly.');
        }else{
            $this->error('File (show.blade.php) already Exist!');
        }
    }
}
