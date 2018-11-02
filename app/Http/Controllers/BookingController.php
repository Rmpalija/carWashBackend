<?php

namespace App\Http\Controllers;

use App\BookWash;
use App\Companies;
use App\Offers;
use App\User;
use App\UserCompanies;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

class BookingController extends Controller
{

    public function create(Request $request){

        $newBooking =  new BookWash([
            'company_id' => $request->get('company_id'),
            'user_id' => $request->get('user_id'),
            'fullName' => $request->get('firstname').' '.$request->get('lastname'),
            'email' => $request->get('email'),
            'date' => $request->get('bookWashDate'),
            'startTime' => $request->get('startTime'),
            'endTime' =>  $request->get('endTime'),
            'book_status' => 0,
            'message' => $request->get('message'),
            'phone_number' => $request->get('phone_number'),
            'vehicleMake' => $request->get('vehicleMake'),
            'vehicleModel' => $request->get('vehicleModel'),
            'offer_id' => $request->get('offer')['id']
        ]);

        $newBooking->save();

        broadcast(new \App\Events\newBooking($newBooking))->toOthers();

        return response()->json(['status' => 'success', 'newBooking' => $newBooking]);

    }

    //Get user bookings / reservations
    public function showUserBookings($id){


        $userBookings = BookWash::select('companies.name as company_name',
            'book_washes.book_status',
            'book_washes.fullName',
            'book_washes.email',
            'book_washes.comment',
            'book_washes.phone_number',
            'book_washes.date',
            'book_washes.message',
            'book_washes.vehicleMake',
            'book_washes.vehicleModel')
            ->join('companies', 'companies.id', '=', 'book_washes.company_id')
            ->where('user_id','=',$id)
            ->orderBy('book_washes.date', 'DESC')
            ->get();


        return response()->json(['status' => 'success', 'bookings' => $userBookings]);
    }

    //Get owners bookings / reservations
    public function showOwnerBookings($user_id){

        $user = User::find($user_id)->toArray();

        if($user['isOwner']){
            $companyIds = UserCompanies::where('user_id','=', $user['id'])->pluck('company_id');

            $ids = $companyIds->toArray();

            $ownerBookings = BookWash::select(
                'companies.name as company_name',
                'book_washes.id',
                'book_washes.book_status',
                'book_washes.fullName',
                'book_washes.email',
                'book_washes.phone_number',
                'book_washes.date',
                'book_washes.startTime',
                'book_washes.endTime',
                'book_washes.message',
                'book_washes.vehicleMake',
                'book_washes.vehicleModel')
                ->join('companies', 'companies.id', '=', 'book_washes.company_id')
                ->whereIn('company_id', $ids)
                ->orderBy('book_washes.date', 'DESC')
                ->get();

            return response()->json(['status' => 'success', 'bookings' => $ownerBookings]);
        }

        return response()->json(['status' => 'error', 'message' => 'Permission denied!']);
    }


    public function acceptBooking($bookingId){
        //UPDATE BOOKING
        $booking =  BookWash::where('id', $bookingId)
            ->update(['book_status' => 1]);

        broadcast(new \App\Events\newBooking($booking))->toOthers();

        return response()->json(['status' => 'success', 'bookings' => $booking]);

    }

    public function declinedBooking(Request $request){

        $input = $request->all();

        //UPDATE BOOKING
        $booking =  BookWash::where('id', $input['bookingId'])
            ->update(['book_status' => 2, 'comment'=>$input['reason']]);

        broadcast(new \App\Events\newBooking($booking))->toOthers();

        return response()->json(['status' => 'success', 'bookings' => $booking]);
    }


    public function editBooking($bookingId, Request $request){

        //UPDATE BOOKING
        BookWash::where('id', $bookingId)
            ->update(['book_status' => 1]);
    }

    public function deleteBooking($bookingId){

        //DELETE BOOKING
        BookWash::where('id', $bookingId)->delete();

        return response()->json(['status' => 'success']);

    }

    public function checkDate(Request $request){


        $bookWash = BookWash::where('company_id','=', $request->get('id'))
            ->where('date', '=', $request->get('date'))
            ->get();

        return response()->json(['status' => 'success', 'booking' => $bookWash]);

    }
}
