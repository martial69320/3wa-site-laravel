<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use Hash;
use Auth;
use Validator;
use Image;

class ProfilController extends Controller
{

    public function profile(){
        return view('profile/profile', array('user' => Auth::user()) );
    }

    public function update(Request $request){


            $user = Auth::user();
            $validation = $this->validator($request->all());

            $json = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . $request->input("zipcode") . '%20france');
            $data = json_decode($json, true);

            $lat = $data['results'][0]['geometry']['location']['lat'];
            $lng = $data['results'][0]['geometry']['location']['lng'];
            $city = $data['results'][0]['address_components'][1]['long_name']; // permet de cibler la ville

            if (!$validation->fails()) {

                if ($request->file('avatar')) {

                    if (!file_exists('uploads/avatars/' . Auth::id())) {
                        mkdir('uploads/avatars/' . Auth::id(), 0755, true);
                    }

                    $files = glob('uploads/avatars/' . Auth::id().'/*'); // get all file names
                    foreach($files as $file){ // iterate files
                        if(is_file($file))
                            unlink($file); // delete file
                    }

                    $avatar = $request->file('avatar');


                    $filename = Auth::id() . '.' . $avatar->getClientOriginalExtension();
                    $filenamethumbs = 'thumbs_' . Auth::id() . '.' . $avatar->getClientOriginalExtension();
                    $filenamemedium = 'medium_' . Auth::id() . '.' . $avatar->getClientOriginalExtension();
                    Image::make($avatar)->save(public_path('uploads/avatars/' . Auth::id() . '/' . $filename));
                    Image::make($avatar)->crop(150, 150)->save(public_path('uploads/avatars/' . Auth::id() . '/' . $filenamethumbs));
                    Image::make($avatar)->widen(800)->save(public_path('uploads/avatars/' . Auth::id() . '/' . $filenamemedium));
                    $user->avatar = $filename;

                }
                $user->name = $request->input('name');
                $user->firstname = $request->input('firstname');
                $user->lastname = $request->input('lastname');
                $user->gender = $request->input('gender');

                $user->email = $request->input('email');
                $user->zipcode = $request->input('zipcode');
                $user->birthday = $request->input('birthday');
                $user->description = $request->input('description');

                $user->lat = $lat;
                $user->lng = $lng;
                $user->city = $city;

                // Il faudra rajouter plus tard les autres champs stipulés dans le cahier des charges (zipcode, lastname etc.)

                $user->save();

                return redirect('/user/'.Auth::id());


            } else {
                return redirect('/profile')->withInput()->withErrors($validation);
            }


            return view('profile/profile', array('user' => Auth::user()));

    }

    protected function validator(array $data)
    {

        $user = Auth::user();
        return Validator::make($data, [
            'name' => 'required|min:5|max:25|alpha_num|unique:users,id,'.$user->id,
            'firstname'=>'required|min:1|max:50|alpha_num',
            'lastname'=>'required|min:1|max:50|alpha_num',
            'gender'=>'required|in:m,f',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'zipcode'=>'required|numeric',
            'birthday' => 'required|date|before:-18 years',
            'avatar' => 'image',
            'description' => 'max:255'

        ]);
    }




    public function update_pass(Request $request){


        $user = Auth::user();

        $rules = ['old_password' => 'required|hash:'.$user->password,
                  'new_password' => 'required|different:old_password|min:6|confirmed'
        ];

        $this->validate($request, $rules);


        /*dd($this->validate($request, $rules));
        exit;*/

        $user->password = bcrypt($request->input('new_password'));
        $user->save();


        return redirect()->back();


    }

}
