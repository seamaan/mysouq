<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Controller extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:controller {name} {path=null}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command Used To Set Controller With Data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
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
            //dd($paths);
            foreach ($paths as $folder)
            {
                if (!is_dir($folder))
                {
                    @mkdir($folder);
                }
            }

        }
    }

    public function Controller($data)
    {
        $path = $this->argument('path') == 'null' ? null : $this->argument('path').'\\';
        $controller_path = app_path('Http/Controllers/'.$data['controller'].'.php');
        $path = str_replace('/', '\\', $path);
        $this->createPath($path);
        $myfile = fopen($controller_path,'w');
        $txt = "Controller\n";
        fwrite($myfile, $txt);
        fclose($myfile);

        $content = file_get_contents($controller_path);
        $namespace = $this->argument('path') == 'null' ? null : '/'.$this->argument('path');
        $namespace = str_replace('/', '\\', $namespace);

       $prefix = strtolower(str_singular(snake_case($data['model'])));
       $prefixs = strtolower(str_plural(snake_case($data['model'])));


        $controller = ucfirst($prefix).'Controller';


        $code ='<?php

namespace App\Http\Controllers'.$namespace.';

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \App\Image;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use \App\Helpers\Classes\Btn;
use \App\\'.ucfirst($prefix).';

class '.$controller.' extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(\'mrole:'.$prefixs.'\');

        resourceBreadcrumbs(\''.$prefix.'\',function($'.$prefix.'){
            return $'.$prefix.'->name;
        });
    }
public function getDatatable()
    {
        $row='.ucfirst($prefix).'::all();
        return Datatables::of($row)
            ->editColumn(\'control\', function ($model) {
                $all=\'\';
                //$all .= Btn::view($model->id,\''.$prefixs.'\',\'users/\'.$model->id.\'/edit\') ;
                $all .= Btn::edit($model->id,\''.$prefixs.'/\'.$model->id.\'/edit\') ;
                $all .= Btn::delete($model->id,$model->name,\'cpanel/'.$prefixs.'/\'.$model->id) ;
                return $all;
            })
            ->editColumn(\'checkbox\', function ($model) {
                $chk=\'\';
                 $chk .=\'<input form="delete_form" id="chkbox\'.$model->id.\'" class="css-checkbox chkbox" type="checkbox" name="delete[]" value="\'.$model->id.\'">\';
                 $chk .=\'<label for="chkbox\'.$model->id.\'" name="checkbox2_lbl" class="css-label lite-red-check"></label>\';
                return $chk;
            })
            ->editColumn(\'name\', function ($model) {
                $name=\'<a href="\'.url(\'cpanel/'.$prefixs.'/\' . $model->id ).\'">\'.$model->name.\'</a> \';
                return $name;
            })
            ->rawColumns([\'checkbox\',\'control\',\'name\'])//render to Html
            ->make(true);
    }
    public function index()
    {
        return \Process::index(\''.$prefixs.'\');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \Process::create(\''.$prefixs.'\');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
           $this->validate($request,[
            \'translate\' => [
                \'name\' => \'required\',
            ],
            //\'name\' => \'required\',

        ]); 

         return \Process::store(request(),\''.$prefixs.'\',[
            \'translate\' => [
                 \'name\',
                 \'content\',
             ],
            //\'name\'=>request(\'name\'),
        ],cp.\''.$prefixs.'\',function ($query){
            return redirect(cp.\''.$prefixs.'\');

        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return \Process::show(\''.$prefixs.'\',$id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return \Process::edit(\''.$prefixs.'\',$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
            $this->validate($request,[
                  \'translate\' => [
                      \'name\' => \'required\',

                    //\'content\' => \'required\',
                  ],
                     //\'name\'=>\'required\',
            ]); 
                      
        return \Process::update($request,$id,\''.$prefixs.'\',[
          \'translate\' => [
                \'name\',
                \'content\',
            ],
           // \'name\'=>request(\'name\'),
        ],cp.\''.$prefixs.'\',function ($query){
            return redirect(cp.\''.$prefixs.'\');
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id = null)
    {
         return  \Process::delete($request,$id,\''.$prefixs.'\');
    }

    public function order(Request $request)
    {
        return \Process::order($request->data,\''.$prefixs.'\',0);
    }

}
';

        file_put_contents($controller_path,$code);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $name = str_singular(camel_case($this->argument('name')));
        $prefix = ucfirst(last(explode('\\',$name)));
        $path = $this->argument('path') == 'null' ? null : $this->argument('path').'\\';
        $path = str_replace('/', '\\', $path);
        $namespace = $this->argument('path') == 'null' ? null : '\\'.$this->argument('path');
        $path_name = $this->argument('path') == 'null' ? null : $this->argument('path');
        $names = [
            'controller' => $path.$prefix.'Controller',
            'model' => $prefix,
        ];
        $this->createPath(app_path('Http/Controllers').'/'.$path);

        $path_url = str_replace('\\', '/', $names['controller']);
        $path_url = str_replace('/', '\\', app_path('Http/Controllers').'/'.$path_url.'.php');
        // $this->error(app_path('Http/Controllers').'/'.$path_url);
        if (file_exists($path_url))
        {
            $this->error('Controller [ '.$names['controller'].' ] Already Exist !');
        }else{

            $this->Controller($names);

            $this->info('Controller [ '.$names['controller'].' ] has been created successfuly');
        }

    }
}
