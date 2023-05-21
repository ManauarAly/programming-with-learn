~~~~~~~~~~~~~~~~~~~ Install ~~~~~~~~~~~~~~~~~~~~
Install composer   --> Dependancy tool
composer create-project laravel/laravel example-app   --> via composer

composer global require laravel/installer  --> via laravel installer
laravel new example-app

php artisan serve  --> run project
sudo kill $(sudo lsof -t -i:8000) --> stop project
php artisan about --> About paravel project

Blade template-
print 
{{$name}} -> Html decode
{!!$name!!} -> Html encode


~~~~~~~~~~~~~~~~~ if, unless ~~~~~~~~~~~~~~~~~~~
Route::get('demo/{name?}/{id?}', function ($name=null, $id = null) {
    $data = compact('name','id');
    return view('demo')->with($data);
});

@if($name)
    Name: {{$name}}
@else
    {{'Name: empty'}}
@endif

@unless($name == 'bis')
    {{'Not a bis..'}}
@endunless

{{$name ?? 'empty'}}
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


~~~~~~~~~~~~~~~~~ Page Layout ~~~~~~~~~~~~~~~~~~
@include('header');
 @yield('main-content')
@include('footer');

Home page-
@extends(main)

@section('main-content')
----------------
----------------
----------------
@endsection

@stack('title')
@push('title')
<title>home</title>
@endpush
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


~~~~~~~~~~~~~~~~~~~~ Form ~~~~~~~~~~~~~~~~~~~~
@csrf --> token validation
print_r($request->all());  --> After submit get the value

Form vadidation ~~~~~~~~
print_r($errors->all());
controller-
$request->validate(
    [
        'name'    => 'required',
        'email'   => 'required|email',
        'pwd'     => 'required',
        'con_pwd' => 'requird|same:pwd'
    ]
);

form-
value="{{old('name')}}" --> Old show in field

@error('name')
    {{$message}}
@enderror

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


~~~~~~~~~~~~~~~~~~ Components ~~~~~~~~~~~~~~~~
php artisan make:component Input

app/view/componet-
public $type; --> class inside
public $type; --> construct inside and alos pass a parammeter in contructor
 
<x-input type="text" name="uname" label="Your name"/> --> calling component on blade file.

<input type="{{$type}}" class="form-control" id="name" placeholder="Enter name" name="{{$name}}"> --> create blade component

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


~~~~~~~~~~~~~~~~~~ Controller ~~~~~~~~~~~~~~~~
Types of controller-
i) Basic Controller
ii) Single Controller
iii) Resource Controller

php artisan make:controller UserController --> Basic contrl
Route::get('/ced', [CedComtroller::class, 'index']); --> web route

php artisan make:controller UserController --invokable --> Single contrl
Route::get('/ced', SingleController::class); --> web route

php artisan make:controller UserController --resource --> Single contrl
Route::resource('/ced', ResourceController::class); --> web route
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


~~~~~~~~~~~~~~~~~~~ Model ~~~~~~~~~~~~~~~~~~~~
php artisan make:model Customer --> Create CL

use HasFactory;
protected $table = "customera";
protected $primaryKey = "customer_id";

php artisan make:model Product --migration --> create model with migration
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


~~~~~~~~~~~~~~~~ Helper file ~~~~~~~~~~~~~~~~~
app/helper.php --> create this file
composer.json
 "autoload": {
        "files": [
            "app/helper.php"   --> composer.json
        ]


composer dump-autoload  --> composer update setting/configuration
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


~~~~~~~~~~~~~ db Manipulating ~~~~~~~~~~~~~~~~
php artisan config:Cache --> clear cache CL
php artisan migrate  --> Run migrate

php artisan make:migration create_customers_table  --> Create migration file

$table->id('customer_id');
$table->string('name',60);
$table->string('email',100);
$table->enum('gender',['M','F','O'])->nullable();
$table->text('address');
$table->date('dob');
$table->boolean('status');
$table->integer('points')->dafaul(1);
$table->timestamps();

php artisan migrate  --> Run migrate
php artisan migrate:rollback  --> rollback migrate
php artisan migrate:refresh  --> rollback-run refresh migrate

Column add-
php artisan make:migration add_columns_to_customers_table
$table->string('country', 50)->nullable()->after('address');
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


~~~~~~~~~~~~~~ Accessor & Mutator ~~~~~~~~~~~~
Modify data inserting & getteing via the db.

Mutator [model] set attribute
public function setNameAttribute($value){
    $this->attributes['name'] = ucwords($value);
}

Accessor [model] get attribute
public function getNameAttribute($value){
    return 'Laravel '.$value;
}
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


~~~~~~~~~~~~~~~~ Session Hendle ~~~~~~~~~~~~~~
* Retrieving data:
$request->sesion()->get('key);
session('key');

* Retrieving All session data:
$request->sesion()->all();
session->all();

* Determining If An Item Exists In The Session:
$request->sesion()->hash('key);
session->key('key');

* Storing Data:
$request->session()->put('key', 'value');
session(['key' => 'value']);

* Flash Data:
$request->session()->flash('status', 'Task was successful!');
session->all();

* Deleting Data:
// Forget a single key...
$request->session()->forget('name');
 
// Forget multiple keys...
$request->session()->forget(['name', 'status']);
 
$request->session()->flush();

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


~~~~~~~~~~~~~~~~~~ Soft Delete ~~~~~~~~~~~~~~~
use Illuminate\Database\Eloquent\SoftDeletes; --> v = Add in model
use SoftDeletes;  --> v

php artisan make:migration add_deleted_at_to_subscriber_table  --> CL
Generate new migration
functon up-
$table->softDeletes();

function down-
 $table->dropSoftDeletes();
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

~~~~~~~~~~~~~ Login/Registration ~~~~~~~~~~~~~
Breeze-- Latest
composer require laravel/ui
composer require laravel/breeze
php artisan breeze:install


Vue--
composer require laravel/ui
php artisan ui vue
php artisan ui vue --auth

Bootstrap--
composer require laravel/ui
php artisan ui bootstrap
php artisan ui bootstrap --auth
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

~~~~~~~~~~~~~~~~~ upload file ~~~~~~~~~~~~~~~~
$request->file('upload-file')->store('uploads');  --> In controller

$fileName = time().'-Aly-'.$request->file('upload-file')->getClientOriginalExtension();
echo $request->file('upload-file')->storeAs('uploads', $fileName);    --> Change uploaded img name.

upload_attachment($request->file('files'), '/webApps/images/profile');

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


~~~~~~~~~~~~~~~~ Seeder/Faker ~~~~~~~~~~~~~~~~
php artisan make:seeder SubscriberSeeder  --> CL

$this->call([ SubscriberSeeder::class ]); --> DatabaseSeeder
php artisan db:seed --> CL

use Faker\Factory as Faker;  --> use on created seeder template.
$faker = Faker::create();  --> run function inside.
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

~~~~~~~~~~~~~~~~~ Pagination ~~~~~~~~~~~~~~~~~~
Subscriber::paginate(10);
{{$subscriber->links()}}
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

~~~~~~~~~~~~~~~ Group Routing ~~~~~~~~~~~~~~~~~
Route::group(['prefix' => '/customer'], function(){
    ----------------
});
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

~~~~~~~~~~~~~~~~~~ Localization ~~~~~~~~~~~~~~~
en/lang.php  --> create folder and file for english
hi/lang.php  --> create folder and file for hindi

config/app.php - 'locale' => 'hi',

web.php --
use Illuminate\Support\Facades\App;
Route::get('/{lang?}', function ($lang=null) {
    app::setLocale($lang);
    return view('welcome');
});
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

~~~~~~~~~~~~~~~~~~~ Stub ~~~~~~~~~~~~~~~~~~~~~~
php artisan stub:publish --> CL

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

~~~~~~~~~~~~~~~~~ Foreign Key ~~~~~~~~~~~~~~~~~
$table->unsignedBigInteger('group_id');
$table->foreign('group_id')->references('group_id')  --> Migration inside add this code.
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


~~~~~~~~~~~~~~~~~ OnetoOne-Join ~~~~~~~~~~~~~~~
Create two model like groups & members.

In member model-
protected $primaryKey = 'member_id';
function getGroup(){
    return $this->hasOne('App\Models\Group', 'group_id');
}

And second group model for connectivity-

Controller inside-
public function index(){
    return Member::find(1)->getGroup;
    return Member::with('getGroup')->get();
}
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

~~~~~~~~~~~~~~~~ OnetoMany-Join ~~~~~~~~~~~~~~~
All functonality same OnetoOne.
return '<pre>'.Member::with('getGroup')->get();
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

~~~~~~~~~~~~~~~~~~ MiddleWare ~~~~~~~~~~~~~~~~~
php artisan make:middleware webGuard  --> CL

Global-
App/Http/Kernal.php --> Create globaly
\App\Http\Middleware\WebGaurd::class,   --> Add Kernal.php

Group Middleware-
'guard' =>[
            \App\Http\Middleware\WebGaurd::class,  --> Add Kernal.php
            \App\Http\Middleware\LoginAuth::class
        ]

Route::middleware(['guard'])->group(function(){
    Route::get('/upload', function(){
        return view('upload');
    });
});
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

~~~~~~~~~~~~~~ Custom Artisan CL ~~~~~~~~~~~~~~
Add this generated console new file.
    php artisan make:command GetDBName --> CL
    
    use Illuminate\Support\Facades\DB;
    protected $signature = 'db:get_db_name';
    protected $description = 'To get the current database name';
    public function handle(){
        $dbname = DB::connection()->getDatabaseName();
        $this->info("The current db name is $dbname");
        return Command::SUCCESS.$dbname;
    }
   

Add this console/Kernal.php
    protected $commands = [
            Commands\GetDBName::class  --> 
        ];

    php artisan --> Check command list CL

new--------
protected $signature = 'user:data {id} {--a|active: Get only active }';

protected $signature = 'user:data {id*} {--a|active}'; --> Id pass in array

    dd($this->option('name'));
    dd($id = $this->argument());
    $id = $this->argument('id');
    $users = User::whereId($id)->get(['id','name','email']);
    $this->table(['id','name','email'],$users);
    $this->error('User Data');
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


~~~~~~~~~~~~~ Route Model Binding ~~~~~~~~~~~~~
In controller-
public function group(modelname $group){
    return $group;
}
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
~~~~~~~~~~~~~~~~ Advance Laravel ~~~~~~~~~~~~~~
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
* Create model with controller.
php artisan make:model Post -mc --> Cl

* Mutator/Accessor in L9.x
public function title():Attribute{
    return new Attribute(
        get: fn($value) => strtoupper($value),
        set: fn($value) =>[
            'title'=> $value,
            'slug' => Str::slug($value)
        ]
    );   
}

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
* Laravel Event and listner
php artisan make:event PostCreated  -->CL
php artisan make:listener NotifyUser -->CL

App\Events-
public $userId; and also call in constractor.

php artisan make:listener NotifyUser --event=PostCreated

App\Listeners-
function handle-
$users = User::get();
foreach($users as $user){
// Mail::send('eventMail', $user, function($message) use ($user){
//     $message->to($event->mailData['id']);
//     $message->subject('Event Testing');
// });

\Mail::to($user->email)->send(new UserMail($event->mailData));
}

php artisan make:mail UserMail
Only view name- Laravel 9

Controller-
$mailData = [
        'id'    => 1,
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp.'
    ];
    event(new SendMail($mailData));

EventServiceProvider file-
SendMail::class => [
            SendMailFired::class,
        ]

php artisan queue:table --> Create queue table
QUEUE_CONNECTION=database --> .evn file

implements ShouldQueue  --> implements in created mail file
php artisan queue:listen --> Re-send mail CL


New --------------
php artisan make:mail SendTestMail --markdown=emails.testmail --> Generate mail file CL
\Mail::to('test@gmail.com')->send(new \App\Mail\SendTestMail()); --> Add in route for testing.

php artisan make:job SendEmailJob --> Job CL
public function handle()
{
    \Mail::to('test@gmail.com')->send(new \App\Mail\SendTestMail());
}

dispatch(new \App\Jobs\SendEmailJob());  --> Route inside after install job.

php artisan queue:table --> Migrate queue table.

php artisan queue:listen --> Store data after run send mail CL

~~~~~~~~~~~~~~ Laravel Observer Events ~~~~~~~~~~~~~~~~~~~
php artisan migrate:fresh --seed

Post.php --> Model
protected static function boot(){
        parent::boot();

        static::saving(function($post){
            $post->slug = Str::slug($post->title);
        });

        static::deleted(function($post){
            $post->comments()->delete();
        });
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    // public function title(): Attribute {
    //     return Attribute::make(
    //         set: fn($value) => [
    //             'slug' => Str::slug($value),
    //             'title'=> $value
    //         ]
    //     );
    // }

php artisan make:observer PostObserver  --> Create observer CL

php artisan make:observer PostObserver --model=Post --> Connection or flag

App\Providers\EventServiceProvider.php --> Add below snniper
public function boot()
    {
        Post::observe(PostObserver::class);
    }
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


~~~~~~~~~~~~~~~~~ CKEditor integration ~~~~~~~~~~~~~~~~~~~~
url: https://cdn.ckeditor.com/#ckeditor

public function uploadimage(Request $request){
        if($request->hasFile('upload')){
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName   = pathinfo($originName, PATHINFO_FILENAME);
            $extension  = $request->file('upload')->getClientOriginalExtension();
            $fileName   = $fileName.'_'.time().'.'.$extension;

            $request->file('upload')->move(public_path('media'), $fileName);

            $url = asset('media/'. $fileName);

            return response()->json(['fileName'=>$fileName, 'uploaded'=>1, 'url'=>$url]);
        }
    }

<script src="https://cdn.ckeditor.com/ckeditor5/35.2.1/classic/ckeditor.js"></script>
 <script>
        ClassicEditor
                .create( document.querySelector( '#editor' ),
                {
                    ckfinder:{
                        uploadUrl: '{{ route('ckeditor.upload').'?_token='.csrf_token() }}'
                    }
                } )
                .then( editor => {
                        console.log( editor );
                } )
                .catch( error => {
                        console.error( error );
                } );
</script>

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


~~~~~~~~~~~~~~~~~~~~~~~~ Rule ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
php artisan make:Rule AgeRule --> Create CL

$age = \Carbon\Carbon::parse($value)->age;   --> Rule page inside.
if($age >= 18){
    return true;
}

$validation = $request->validate([
    'dob' => ['required', 'date', new AgeRule]  --> ontrolleride.
]);
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

~~~~~~~~~~~~~~~~~~~~~~~~ Rule ~~~~~~~~~~~~~~~~~~~~~~~~~~~~
php artisan test --> CL
./vendor/bin/phpunit --filter --> CL2

php  artisan make:test PostController --> Create test CL

 

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


