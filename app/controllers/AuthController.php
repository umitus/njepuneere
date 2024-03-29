<?php
	class AuthController extends BaseController {

		/* Kullanıcı Kayıdı */
		public function getBireyKayit()
		{

			return View::make('auth.register');
		}
		public function postBireyKayit()
		{
			$d_tarihi = Input::get('yy') . '-' . Input::get('mm') . '-' . Input::get('dd');
			$input = Input::all();
			$rules = array ('adi' => 'required',
							'soyadi' => 'required',
							'email'=> 'required|unique:birey_user|email',
							'sifre' => 'required');
			$v = Validator::make($input,$rules);
			
			if($v->passes())
			{
				$user = new Birey_user;
				$user->adi = Input::get('adi');
				$user->soyadi = Input::get('soyadi');
				$user->email = Input::get('email');
				$user->sifre = Hash::make(Input::get('sifre'));
				$user->passwordConfirm = Hash::make(Input::get('passwordConfirm'));
				$user->cinsiyet = Input::get('cinsiyet');
				$user->d_tarihi = $d_tarihi;
				$user->tel = Input::get('tel');
				$user->ulke = Input::get('ulke');
				$user->sehir = Input::get('sehir');
				$user->uni = Input::get('uni');
				$user->sonis = Input::get('sonis');
				$user->durum = Input::get('durum');
				$user->about_me = Input::get('about_me');
				$user->save();

				return Redirect::to('/');
			}
			return Redirect::to('BireyKayit')->withErrors($v);

		}
		public function postPr_img()
		{
			$input = Input::all();
			$rules = array ('pr_img' => 'required|image|max:1000');
			$v = Validator::make($input,$rules);

			if($v->passes()){
				$pr_img = Input::file('pr_img');
				$filename = Auth::user()->adi.Auth::user()->soyadi.'-'.Auth::user()->id.'.jpg';//burada ayni isimde kaydettiriyorum sorun olabilir!
				$path = public_path('img/pr_img/' . $filename);
				Image::make($pr_img->getRealPath())->resizeCanvas(10, -10, 'center', true)->save($path);
				$pr_img = '/img/pr_img/'.$filename;
				$pr_img = User::where('id', '=', Auth::user()->id)->update(array('pr_img' => $pr_img));

				return Redirect::back();
			}
			return Redirect::back()->withErrors($v);
		}

		/* Kullanıcı Girişi */
		public function getBireyGiris()
		{
			if (Auth::check()) return Redirect::to('/');
			return View::make('auth.login');
		}
		
		public function postBireyGiris()
		{
			$input = Input::all();
			$rules = array('email' => 'required', 'sifre' => 'required');
			$v = Validator::make($input, $rules);
			if($v->passes())
			{
				$kimlik = array('email' => Input::get('email'), 'password' => Input::get('sifre'));
				if(Auth::attempt($kimlik)){
					return Redirect::back();
				} else {
					return Redirect::to('BireyGiris');
				}
			}
			return Redirect::to('BireyGiris')->withErrors($v);
		}

		public function user_update()
		{
			$user = Auth::user();
			$noti_cv = DB::table('tbl_new_cv')->where('user_id','=',Auth::user()->id)->count();
			$noti_app = DB::table('tbl_new_apply')->where('user_id','=',Auth::user()->id)->count();
			return View::make('auth.userup')->with('noti_cv',$noti_cv)->with('noti_app',$noti_app)->with('user',$user);
		}

		public function logout()
		{

			Auth::logout();
			return Redirect::to('/');
		}
		

	}
