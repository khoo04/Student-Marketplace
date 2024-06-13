<?php

namespace App\Http\Controllers;

use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingAddressController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();

        $validatedFields = $request->validate([
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'address' => 'required|string',
            'default_address' => 'nullable|string',
        ]);

        $defaultAddress = isset($validatedFields['default_address']) ? true : false;
        $addressLines = explode("\n", $request->address);
        $addressLine1 = isset($addressLines[0]) ? $addressLines[0] : '';
        $addressLine2 = isset($addressLines[1]) ? $addressLines[1] : '';

        if (count($user->addresses) == 0) {
            $defaultAddress = true;
        }
        //If user does not have address before, the first address added is set as default.
        if ($defaultAddress) {
            ShippingAddress::where('user_id', Auth::id())->update(['default' => false]);
        }
        
        $user->addresses()->create([
            'address_line_1' => $addressLine1,
            'address_line_2' => $addressLine2,
            'city' => $validatedFields['city'],
            'state' => $validatedFields['state'],
            'zip_code' => $validatedFields['postal_code'],
            'default' => $defaultAddress,
        ]);

        return redirect()->route('profile')->with(['message' => 'Address added successfully', 'type' => 'success', 'pageIndex' => 1]);
    }

    public function update(Request $request)
    {
        $validatedFields = $request->validate([
            'address_id' => 'required',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $addressID = $validatedFields['address_id'];
        $address = ShippingAddress::find($addressID);

        if ($address && $address->user_id === Auth::id()) {
            $addressLines = explode("\n", $request->address);
            $address->address_line_1 = isset($addressLines[0]) ? $addressLines[0] : '';
            $address->address_line_2 = isset($addressLines[1]) ? $addressLines[1] : '';
            $address->city = $validatedFields['city'];
            $address->state = $validatedFields['state'];
            $address->zip_code = $validatedFields['postal_code'];

            $address->save();

            return redirect()->route('profile')->with(['message' => 'Address updated successfully', 'type' => 'success', 'pageIndex' => 1]);
        }

        return redirect()->route('profile')->with(['message' => 'Failed to update address', 'type' => 'error', 'pageIndex' => 1]);
    }

    public function getDetails(Request $request)
    {
        $addressID = $request->input('address_id');
        $address = ShippingAddress::find($addressID);

        if ($address && $address->user_id === Auth::id()) {
            return response()->json([
                'status' => 'success',
                'address_id' => $address->id,
                'city' => $address->city,
                'state' => $address->state,
                'zip_code' => $address->zip_code,
                'address_line_1' => $address->address_line_1,
                'address_line_2' => $address->address_line_2

            ]);
        }
        return response()->json(['status ' => 'failed']);
    }

    public function setAsDefault(Request $request)
    {
        $address = ShippingAddress::find($request->address_id);

        if ($address) {
            ShippingAddress::where('user_id', Auth::id())->update(['default' => false]);
            $address->default = true;
            $address->save();
            return redirect()->route('profile')->with(['message' => 'Address set as default successfully', 'type' => 'success', 'pageIndex' => 1]);
        }
        return redirect()->route('profile')->with(['message' => 'Action failed', 'type' => 'alert', 'pageIndex' => 1]);
    }

    public function destroy(Request $request)
    {
        $addressID = $request->input('address_id');
        $address = ShippingAddress::find($addressID);

        if ($address && $address->user_id === Auth::id()) {
            // Delete the address
            if ($address->default) {
                return response()->json(['status ' => 'failed', 'message' => 'Failed to delete default address']);
            }
            $address->delete();
            return response()->json(['status' => 'success', 'message' => 'Address has been deleted']);
        }
        return response()->json(['status ' => 'failed', 'message' => 'Failed to delete address']);
    }
}
