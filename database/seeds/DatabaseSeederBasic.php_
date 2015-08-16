<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Parking;
use App\Availability;
use App\Location;
use App\ParkingLocation;
use App\RateDaily;
use App\RateHourly;
use App\Field;
use App\ParkingField;
use App\Booking;
use App\User;
use App\Translation;
use App\Configuration;
use App\Tag;
use App\ParkingTag;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

        $this->call('TagsTableSeeder');
		//$this->call('ParkingTableSeeder');
		//$this->call('AvailabilityTableSeeder');
		//$this->call('LocationTableSeeder');
		//$this->call('ParkingLocationTableSeeder');
		$this->call('RateDailyTableSeeder');
		$this->call('RateHourlyTableSeeder');
		$this->call('FieldTableSeeder');
		//$this->call('ParkingFieldTableSeeder');
		//$this->call('BookingTableSeeder');
        $this->call('UserTableSeeder');
        $this->call('TranslationTableSeeder');
        //$this->call('ConfigurationTableSeeder');
        //$this->call('ParkingTagTableSeeder');
        
	}

}

class ParkingTableSeeder extends Seeder {

    public function run()
    {
        DB::table('PARKING')->delete();
        // 1= daily, 2= hourly
        Parking::create(['parking_name' => 'Chelnik Parking',
        				 'status'		=> 'A',
        				 'slots'		=> 3,
        				 'rate_type'	=> 'D',
        				 'min_duration'	=> 1,
        				 'early_booking'=> 24,
        				 'description'	=> 'This open-air lot is located between Kips Bay and Gramercy Park! The location will have a chain linked fence as well as a huge black pole that says "PARK" in white with an arrow pointing towards the entrance. This lift lot is adjacent to Chimi Sushi.</br></br>Vehicle height restriction: 75 inches</br></br>This location is a commercial parking garage.</br></br>Nearby destinations: Gramercy Theatre, School of Visual Arts, Maialino, United Charities Building Complex.',
        				 'find_it'		=> 'This surface lot is located on E 26th St, between 2nd and 3rd Ave. The entrance will be on the north side of E 26th St. Please be advised that E 26th St runs one way east. This is a valet parking location.',
        				 'image_count'	=> 2,
        				 'address'		=> '211 E. 26th St., London Airport, LA 10010',
        				 'reserve_notes'=> 'Upon arrival, please hand the parking pass to the attendant for validation.</br>Oversize vehicle fee, $10, will be applied onsite.',
        				 'gmaps' 		=> '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d756.6995905456449!2d22.92315610000001!3d40.656375000000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a839937a30c399%3A0x9d2c8c7d3b9a001f!2zzqDOsc-AzrHPhs67zq3Pg8-DzrEgMTcsIM6fzrnOus65z4POvM-Mz4IgzpzOsc66zrXOtM6_zr3Or86xIDU2MSAyMQ!5e0!3m2!1sel!2sgr!4v1411679516473" width="300" height="450" frameborder="0" style="border:0"></iframe>',
                         'lat'          => 51.515451,
                         'lng'          => -0.157388,
						 'timezone'     => 'Europe/London']);

		Parking::create(['parking_name' => 'Impark',
        				 'status'		=> 'A',
        				 'slots'		=> 10,
        				 'rate_type'	=> 'H',
        				 'min_duration'	=> 2,
        				 'early_booking'=> 12,
        				 'description'	=> 'Parking description',
        				 'find_it'		=> 'Parking find it',
        				 'image_count'	=> 2,
        				 'address'		=> '305 W. 42nd St., London Airport, LA 10036',
        				 'reserve_notes'=> 'Upon arrival, please hand the parking pass to the attendant for validation.</br>Oversize vehicle fee, $10, will be applied onsite.',
        				 'gmaps' 		=> '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d756.6995905456449!2d22.92315610000001!3d40.656375000000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a839937a30c399%3A0x9d2c8c7d3b9a001f!2zzqDOsc-AzrHPhs67zq3Pg8-DzrEgMTcsIM6fzrnOus65z4POvM-Mz4IgzpzOsc66zrXOtM6_zr3Or86xIDU2MSAyMQ!5e0!3m2!1sel!2sgr!4v1411679516473" width="300" height="450" frameborder="0" style="border:0"></iframe>',
                         'lat'          => 51.504764,
                         'lng'          => -0.151079,
						 'timezone'     => 'Europe/London']);

		Parking::create(['parking_name' => 'Bright Management',
        				 'status'		=> 'A',
        				 'slots'		=> 5,
        				 'rate_type'	=> 'D',
        				 'min_duration'	=> 5,
        				 'early_booking'=> 48,
        				 'description'	=> 'Parking description',
        				 'find_it'		=> 'Parking find it',
        				 'image_count'	=> 0,
        				 'address'		=> '344 W. 45th St., London Airport, LA 10036',
        				 'reserve_notes'=> 'Parking reserve notes',
        				 'gmaps' 		=> '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d756.6995905456449!2d22.92315610000001!3d40.656375000000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a839937a30c399%3A0x9d2c8c7d3b9a001f!2zzqDOsc-AzrHPhs67zq3Pg8-DzrEgMTcsIM6fzrnOus65z4POvM-Mz4IgzpzOsc66zrXOtM6_zr3Or86xIDU2MSAyMQ!5e0!3m2!1sel!2sgr!4v1411679516473" width="300" height="450" frameborder="0" style="border:0"></iframe>',
                         'lat'          => 51.501772,
                         'lng'          => -0.158547,
						 'timezone'     => 'Europe/London']);

		Parking::create(['parking_name' => 'Select Garages',
        				 'status'		=> 'A',
        				 'slots'		=> 25,
        				 'rate_type'	=> 'H',
        				 'min_duration'	=> 1,
        				 'early_booking'=> 60,
        				 'description'	=> 'Parking description',
        				 'find_it'		=> 'Parking find it',
        				 'image_count'	=> 0,
        				 'address'		=> '320 W. 36th St., Manchester, MA 10018',
        				 'reserve_notes'=> 'Parking reserve notes',
        				 'gmaps' 		=> '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d756.6995905456449!2d22.92315610000001!3d40.656375000000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a839937a30c399%3A0x9d2c8c7d3b9a001f!2zzqDOsc-AzrHPhs67zq3Pg8-DzrEgMTcsIM6fzrnOus65z4POvM-Mz4IgzpzOsc66zrXOtM6_zr3Or86xIDU2MSAyMQ!5e0!3m2!1sel!2sgr!4v1411679516473" width="300" height="450" frameborder="0" style="border:0"></iframe>',
                         'lat'          => 51.501522,
                         'lng'          => -0.156691,
						 'timezone'     => 'Europe/London']);

		Parking::create(['parking_name' => 'LAZ Parking',
        				 'status'		=> 'I',
        				 'slots'		=> 50,
        				 'rate_type'	=> 'D',
        				 'min_duration'	=> 1,
        				 'early_booking'=> 24,
        				 'description'	=> 'Parking description',
        				 'find_it'		=> 'Parking find it',
        				 'image_count'	=> 0,
        				 'address'		=> '247 W. 46th St., Manchester, MA 10036',
        				 'reserve_notes'=> 'Parking reserve notes',
        				 'gmaps' 		=> '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d756.6995905456449!2d22.92315610000001!3d40.656375000000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a839937a30c399%3A0x9d2c8c7d3b9a001f!2zzqDOsc-AzrHPhs67zq3Pg8-DzrEgMTcsIM6fzrnOus65z4POvM-Mz4IgzpzOsc66zrXOtM6_zr3Or86xIDU2MSAyMQ!5e0!3m2!1sel!2sgr!4v1411679516473" width="300" height="450" frameborder="0" style="border:0"></iframe>',
                         'lat'          => 51.501306,
                         'lng'          => -0.170904]);

		Parking::create(['parking_name' => 'MTP Parking',
        				 'status'		=> 'A',
        				 'slots'		=> 5,
        				 'rate_type'	=> 'D',
        				 'min_duration'	=> 24,
        				 'early_booking'=> 24,
        				 'description'	=> 'Parking description',
        				 'find_it'		=> 'Parking find it',
        				 'image_count'	=> 0,
        				 'address'		=> '35 W. 33rd St, Manchester, MA 10001',
        				 'reserve_notes'=> 'Parking reserve notes',
        				 'gmaps' 		=> '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d756.6995905456449!2d22.92315610000001!3d40.656375000000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a839937a30c399%3A0x9d2c8c7d3b9a001f!2zzqDOsc-AzrHPhs67zq3Pg8-DzrEgMTcsIM6fzrnOus65z4POvM-Mz4IgzpzOsc66zrXOtM6_zr3Or86xIDU2MSAyMQ!5e0!3m2!1sel!2sgr!4v1411679516473" width="300" height="450" frameborder="0" style="border:0"></iframe>',
                         'lat'          => 51.504986,
                         'lng'          => -0.172964,
						 'timezone'     => 'Europe/London']);

		Parking::create(['parking_name' => 'LittleMan Parking',
        				 'status'		=> 'A',
        				 'slots'		=> 15,
        				 'rate_type'	=> 'H',
        				 'min_duration'	=> 2,
        				 'early_booking'=> 24,
        				 'description'	=> 'Parking description',
        				 'find_it'		=> 'Parking find it',
        				 'image_count'	=> 0,
        				 'address'		=> '217 W. 29th St., Birmingham, BR 10001',
        				 'reserve_notes'=> 'Parking reserve notes',
        				 'gmaps' 		=> '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d756.6995905456449!2d22.92315610000001!3d40.656375000000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a839937a30c399%3A0x9d2c8c7d3b9a001f!2zzqDOsc-AzrHPhs67zq3Pg8-DzrEgMTcsIM6fzrnOus65z4POvM-Mz4IgzpzOsc66zrXOtM6_zr3Or86xIDU2MSAyMQ!5e0!3m2!1sel!2sgr!4v1411679516473" width="300" height="450" frameborder="0" style="border:0"></iframe>',
                         'lat'          => 51.501086,
                         'lng'          => -0.180388,
						 'timezone'     => 'Europe/London']);

		Parking::create(['parking_name' => 'The Eventi Hotel',
        				 'status'		=> 'I',
        				 'slots'		=> 500,
        				 'rate_type'	=> 'D',
        				 'min_duration'	=> 1,
        				 'early_booking'=> 24,
        				 'description'	=> 'Parking description',
        				 'find_it'		=> 'Parking find it',
        				 'image_count'	=> 0,
        				 'address'		=> '851 6th Ave., Birmingham, BR 10001',
        				 'reserve_notes'=> 'Parking reserve notes',
        				 'gmaps' 		=> '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d756.6995905456449!2d22.92315610000001!3d40.656375000000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a839937a30c399%3A0x9d2c8c7d3b9a001f!2zzqDOsc-AzrHPhs67zq3Pg8-DzrEgMTcsIM6fzrnOus65z4POvM-Mz4IgzpzOsc66zrXOtM6_zr3Or86xIDU2MSAyMQ!5e0!3m2!1sel!2sgr!4v1411679516473" width="300" height="450" frameborder="0" style="border:0"></iframe>',
                         'lat'          => 51.506228,
                         'lng'          => -0.146957,
						 'timezone'     => 'Europe/London']);

		Parking::create(['parking_name' => 'MPG Parking',
        				 'status'		=> 'A',
        				 'slots'		=> 25,
        				 'rate_type'	=> 'H',
        				 'min_duration'	=> 1,
        				 'early_booking'=> 24,
        				 'description'	=> 'Parking description',
        				 'find_it'		=> 'Parking find it',
        				 'image_count'	=> 0,
        				 'address'		=> '923 5th Ave., Birmingham, BR 10021',
        				 'reserve_notes'=> 'Parking reserve notes',
        				 'gmaps' 		=> '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d756.6995905456449!2d22.92315610000001!3d40.656375000000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a839937a30c399%3A0x9d2c8c7d3b9a001f!2zzqDOsc-AzrHPhs67zq3Pg8-DzrEgMTcsIM6fzrnOus65z4POvM-Mz4IgzpzOsc66zrXOtM6_zr3Or86xIDU2MSAyMQ!5e0!3m2!1sel!2sgr!4v1411679516473" width="300" height="450" frameborder="0" style="border:0"></iframe>',
                         'lat'          => 51.510702,
                         'lng'          => -0.140455,
						 'timezone'     => 'Europe/London']);

		Parking::create(['parking_name' => 'Edison ParkFast',
        				 'status'		=> 'A',
        				 'slots'		=> 10,
        				 'rate_type'	=> 'H',
        				 'min_duration'	=> 1,
        				 'early_booking'=> 24,
        				 'description'	=> 'This parking garage is located on the south side of 44th St across from The Algonquin Hotel. The garage entrance will be identified by a grated metal awning. The garage is adjacent to a Gregory\'s Coffee which you will see before the entrance of the lot. This location will leave you minutes away The Theatre District, as well as other sites such as Bryant Park and New York Public Library.</br>*Note: Oversize vehicles will be charged an additional $10.00 per day.</br>Vehicle height restriction: 78 inches</br>This location is a commercial parking garage.</br>Nearby destinations: Minskoff Theatre, Lunt-Fontanne Theatre, Best Buy Theater, Nederlander Theatre, Foxwoods Theatre.',
        				 'find_it'		=> 'This parking garage is located on 44th St between 6th Ave and 5th Ave. The entrance will be on the south side 44th St across from The Algonquin Hotel. Be advised that best route is to enter 44th St coming from 6th Ave.',
        				 'image_count'	=> 2,
        				 'address'		=> '50 W. 44th St., London Airport, LA 10036',
        				 'reserve_notes'=> 'Upon arrival, take a ticket from the machine. Before departing, see the attendant to return that ticket and validate your pass.</br>Oversize vehicles will be charged an additional $10.00 per day on-site. Early arrival or late departure from the selected times may have major rate increases.',
        				 'gmaps' 		=> '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d756.6995905456449!2d22.92315610000001!3d40.656375000000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a839937a30c399%3A0x9d2c8c7d3b9a001f!2zzqDOsc-AzrHPhs67zq3Pg8-DzrEgMTcsIM6fzrnOus65z4POvM-Mz4IgzpzOsc66zrXOtM6_zr3Or86xIDU2MSAyMQ!5e0!3m2!1sel!2sgr!4v1411679516473" width="300" height="450" frameborder="0" style="border:0"></iframe>',
                         'lat'          => 51.515536,
                         'lng'          => -0.157321,
						 'timezone'     => 'Europe/London']);

    }

}

class AvailabilityTableSeeder extends Seeder {

    public function run()
    {
        DB::table('AVAILABILITY')->delete();
        
        //1
        Availability::create(['parking_id' => 1, 'date' => '2015-7-1', 'time_start' => '00:00:00', 'time_end' => '21:00:00', 'slots' => 3, 'remaining_slots' => 1, 'status' => 'A']);
        Availability::create(['parking_id' => 1, 'date' => '2015-7-2', 'slots' => 3, 'remaining_slots' => 1, 'status' => 'A']);
        Availability::create(['parking_id' => 1, 'date' => '2015-7-3', 'slots' => 3, 'remaining_slots' => 3, 'status' => 'A']);

        //2
        Availability::create(['parking_id' => 2, 'date' => '2015-7-1', 'slots' => 10, 'remaining_slots' => 1,  'status' => 'A']);
        Availability::create(['parking_id' => 2, 'date' => '2015-7-2', 'slots' => 10, 'remaining_slots' => 5,  'status' => 'A']);
        Availability::create(['parking_id' => 2, 'date' => '2015-7-3', 'slots' => 10, 'remaining_slots' => 10, 'status' => 'A']);

        //3
        Availability::create(['parking_id' => 3, 'date' => '2015-7-1', 'slots' => 5, 'remaining_slots' => 5, 'status' => 'A']);
        Availability::create(['parking_id' => 3, 'date' => '2015-7-2', 'slots' => 5, 'remaining_slots' => 5, 'status' => 'I']);
        Availability::create(['parking_id' => 3, 'date' => '2015-7-3', 'slots' => 5, 'remaining_slots' => 0, 'status' => 'I']);

        //10
        Availability::create(['parking_id' => 10, 'date' => '2015-7-1', 'slots' => 3, 'remaining_slots' => 1, 'status' => 'A']);
    }

}

class LocationTableSeeder extends Seeder {

    public function run()
    {
        DB::table('LOCATION')->delete();
        
        Location::create(['name'                => 'United Kingdom', 
                          'status'              => 'A', 
                          'location_parent_id'	=> NULL, 
                          'lat'                 => NULL, 
                          'lng'                 => NULL, 
                          'currency'            => '£', 
                          'currency_order'      => 'L']); //1

        Location::create(['name'                => 'Greece',         
                          'status'              => 'A', 
                          'location_parent_id'  => NULL, 
                          'lat'                 => NULL, 
                          'lng'                 => NULL, 
                          'currency'            => '€',
                          'currency_order'      => 'R']); //2

        Location::create(['name' => 'London', 		  	  'status' => 'A', 'location_parent_id'	=> 1, 'lat' => 51.512406,  'lng' => -0.128721]); //3
        Location::create(['name' => 'Manchester', 	  	  'status' => 'A', 'location_parent_id'	=> 1, 'lat' => 53.4778035, 'lng' => -2.2340929]);
        Location::create(['name' => 'Birmingham', 	  	  'status' => 'A', 'location_parent_id'	=> 1, 'lat' => 52.48142,   'lng' => -1.89983]);
        Location::create(['name' => 'Liverpool', 	  	  'status' => 'I', 'location_parent_id'	=> 1, 'lat' => NULL,       'lng' => NULL]);
        Location::create(['name' => 'London Airport', 	  'status' => 'A', 'location_parent_id'	=> 1, 'lat' => NULL,       'lng' => NULL]);
        Location::create(['name' => 'Manchester Airport', 'status' => 'A', 'location_parent_id'	=> 1, 'lat' => NULL,       'lng' => NULL]);
        Location::create(['name' => 'Birmingham Airport', 'status' => 'I', 'location_parent_id'	=> 1, 'lat' => NULL,       'lng' => NULL]);
        Location::create(['name' => 'Liverpool Airport',  'status' => 'A', 'location_parent_id'	=> 1, 'lat' => NULL,       'lng' => NULL]);

        
        Location::create(['name' => 'Athens',       'status' => 'A', 'location_parent_id' => 2, 'lat' => 37.984005, 'lng' => 23.728898]);
        Location::create(['name' => 'Thessaloniki', 'status' => 'A', 'location_parent_id' => 2, 'lat' => 40.639171, 'lng' => 22.939633]);
        Location::create(['name' => 'Volos',        'status' => 'A', 'location_parent_id' => 2, 'lat' => 39.360854, 'lng' => 22.947012]);
    }

}

class ParkingLocationTableSeeder extends Seeder {

    public function run()
    {
        DB::table('PARKING_LOCATION')->delete();
        
        ParkingLocation::create(['parking_id' => 1, 'location_id' => 3, 'status' => 'A']);
        ParkingLocation::create(['parking_id' => 1, 'location_id' => 6, 'status' => 'A']);
        
        ParkingLocation::create(['parking_id' => 2, 'location_id' => 3, 'status' => 'A']);
        ParkingLocation::create(['parking_id' => 2, 'location_id' => 6, 'status' => 'A']);
        
        ParkingLocation::create(['parking_id' => 3, 'location_id' => 6, 'status' => 'Ι']);
        ParkingLocation::create(['parking_id' => 3, 'location_id' => 3, 'status' => 'A']);

        ParkingLocation::create(['parking_id' => 4, 'location_id' => 3, 'status' => 'A']);
        ParkingLocation::create(['parking_id' => 4, 'location_id' => 7, 'status' => 'A']);

        ParkingLocation::create(['parking_id' => 5, 'location_id' => 3, 'status' => 'A']);
        
        ParkingLocation::create(['parking_id' => 6, 'location_id' => 3, 'status' => 'A']);
        
        ParkingLocation::create(['parking_id' => 7, 'location_id' => 4, 'status' => 'A']);
        
        ParkingLocation::create(['parking_id' => 8, 'location_id' => 4, 'status' => 'A']);
        
        ParkingLocation::create(['parking_id' => 9, 'location_id' => 4, 'status' => 'A']);
        
        ParkingLocation::create(['parking_id' => 10, 'location_id' => 3, 'status' => 'A']);
        ParkingLocation::create(['parking_id' => 10, 'location_id' => 6, 'status' => 'A']);

    }

}

class RateDailyTableSeeder extends Seeder {

    public function run()
    {
        DB::table('RATE_DAILY')->delete();
        
        RateDaily::create(['parking_id' => 1, 'day' => 1,  'price' => 10]);
        RateDaily::create(['parking_id' => 1, 'day' => 2,  'price' => 9.5]);
        RateDaily::create(['parking_id' => 1, 'day' => 3,  'price' => 9]);
        RateDaily::create(['parking_id' => 1, 'day' => 7,  'price' => 8]);
        RateDaily::create(['parking_id' => 1, 'day' => 14, 'price' => 7]);
        RateDaily::create(['parking_id' => 1, 'day' => 31, 'price' => 6]);

        RateDaily::create(['parking_id' => 3, 'day' => 1,  'price' => 10, 	    'discount' => NULL]);
        RateDaily::create(['parking_id' => 3, 'day' => 2,  'price' => 10*0.95,  'discount' => 0.95]);
        RateDaily::create(['parking_id' => 3, 'day' => 3,  'price' => 10*0.9,   'discount' => 0.9]);
        RateDaily::create(['parking_id' => 3, 'day' => 7,  'price' => 10*0.815, 'discount' => 0.815]);
        RateDaily::create(['parking_id' => 3, 'day' => 14, 'price' => 10*0.7,   'discount' => 0.7]);
        RateDaily::create(['parking_id' => 3, 'day' => 31, 'price' => 10*0.6,   'discount' => 0.6]);

    }

}

class RateHourlyTableSeeder extends Seeder {

    public function run()
    {
        DB::table('RATE_HOURLY')->delete();

        RateHourly::create(['parking_id' => 2, 'hours' => 1,  'price' => 2.5]);
        RateHourly::create(['parking_id' => 2, 'hours' => 2,  'price' => 2.3]);
        RateHourly::create(['parking_id' => 2, 'hours' => 3,  'price' => 2.2]);
        RateHourly::create(['parking_id' => 2, 'hours' => 5,  'price' => 2]);
        RateHourly::create(['parking_id' => 2, 'hours' => 10, 'price' => 1.7]);
        RateHourly::create(['parking_id' => 2, 'hours' => 24, 'price' => 1.6]);

        RateHourly::create(['parking_id' => 10, 'hours' => 24,  'price' => 1.56, 	   'discount' => NULL,  'free_mins' => 10]);
        RateHourly::create(['parking_id' => 10, 'hours' => 48,  'price' => 1.56*0.95,  'discount' => 0.95,  'free_mins' => 50]);
        RateHourly::create(['parking_id' => 10, 'hours' => 100, 'price' => 1.56*0.9,   'discount' => 0.9,   'free_mins' => 50]);
        RateHourly::create(['parking_id' => 10, 'hours' => 200, 'price' => 1.56*0.815, 'discount' => 0.815, 'free_mins' => 100]);
        RateHourly::create(['parking_id' => 10, 'hours' => 300, 'price' => 1.56*0.7,   'discount' => 0.7,   'free_mins' => 100]);
        RateHourly::create(['parking_id' => 10, 'hours' => 500, 'price' => 1.56*0.6,   'discount' => 0.6,   'free_mins' => 100]);

    }

}

class FieldTableSeeder extends Seeder {

    public function run()
    {
        DB::table('FIELD')->delete();

        Field::create(['field_name' => 'title',     'type' => 'select', 'attributes' => '{"Mr":"Mr","Mrs":"Mrs"}', 'label' => 'Title']);
       	Field::create(['field_name' => 'firstname', 'type' => 'text',   'attributes' => NULL, 'label' => 'First Name']);
       	Field::create(['field_name' => 'lastname',  'type' => 'text',   'attributes' => NULL, 'label' => 'Last Name']);
       	Field::create(['field_name' => 'mobile',    'type' => 'text',   'attributes' => NULL, 'label' => 'Mobile Number']);
       	Field::create(['field_name' => 'landline',  'type' => 'text',   'attributes' => NULL, 'label' => 'Landline Number']);
       	Field::create(['field_name' => 'email',     'type' => 'text',   'attributes' => NULL, 'label' => 'Email Address']);
       	Field::create(['field_name' => 'carmake',   'type' => 'text',   'attributes' => NULL, 'label' => 'Car Make']);
       	Field::create(['field_name' => 'carmodel',  'type' => 'text',   'attributes' => NULL, 'label' => 'Car Model']);
       	Field::create(['field_name' => 'carreg',    'type' => 'text',   'attributes' => NULL, 'label' => 'Car Registration']);
       	Field::create(['field_name' => 'carcolour', 'type' => 'text',   'attributes' => NULL, 'label' => 'Car Colour']);
       	Field::create(['field_name' => 'passengers','type' => 'select', 'attributes' => '{"1":"1","2":"2","3":"3","4":"4","5":"5"}', 'label' => 'No of Passengers']);

    }

}

class ParkingFieldTableSeeder extends Seeder {

    public function run()
    {
        DB::table('PARKING_FIELD')->delete();

        ParkingField::create(['parking_id' => 1, 'field_id' => 1,  'required' => 'Υ']);
       	ParkingField::create(['parking_id' => 1, 'field_id' => 2,  'required' => 'Υ']);
       	ParkingField::create(['parking_id' => 1, 'field_id' => 3,  'required' => 'Υ']);
       	ParkingField::create(['parking_id' => 1, 'field_id' => 4,  'required' => 'Υ']);
       	ParkingField::create(['parking_id' => 1, 'field_id' => 5,  'required' => 'N']);
       	ParkingField::create(['parking_id' => 1, 'field_id' => 6,  'required' => 'Υ']);
       	ParkingField::create(['parking_id' => 1, 'field_id' => 7,  'required' => 'Υ']);
       	ParkingField::create(['parking_id' => 1, 'field_id' => 8,  'required' => 'Υ']);
       	ParkingField::create(['parking_id' => 1, 'field_id' => 9,  'required' => 'Υ']);
       	ParkingField::create(['parking_id' => 1, 'field_id' => 10, 'required' => 'Υ']);
       	ParkingField::create(['parking_id' => 1, 'field_id' => 11, 'required' => 'N']);

        ParkingField::create(['parking_id' => 2, 'field_id' => 1,  'required' => 'Υ']);
        ParkingField::create(['parking_id' => 2, 'field_id' => 2,  'required' => 'Υ']);
        ParkingField::create(['parking_id' => 2, 'field_id' => 3,  'required' => 'Υ']);
        ParkingField::create(['parking_id' => 2, 'field_id' => 4,  'required' => 'Υ']);
        ParkingField::create(['parking_id' => 2, 'field_id' => 6,  'required' => 'Υ']);
        ParkingField::create(['parking_id' => 2, 'field_id' => 7,  'required' => 'Υ']);
        ParkingField::create(['parking_id' => 2, 'field_id' => 8,  'required' => 'Υ']);
        ParkingField::create(['parking_id' => 2, 'field_id' => 9,  'required' => 'Υ']);
    }

}

class BookingTableSeeder extends Seeder {

    public function run()
    {
        DB::table('BOOKING')->delete();

        for ($i = 0; $i <= 40; $i++) {
            Booking::create(['booking_ref' => 'PL151'.$i,
                             'parking_id' => 1, 
        					 'checkin' => '2015-05-01 10:20',
        					 'checkout' => '2015-05-30 23:50',  
        					 'price' => 24.56,
        					 'title' => 'Mr',
        					 'firstname' => 'Michael',
        					 'lastname' => 'Tsilikidis',
        					 'mobile' => '07932019794',
        					 'email' => 't.mihalis@gmail.com',
        					 'car_make' => 'Opel',
        					 'car_model' => 'Vectra',
        					 'car_reg' => 'VD34 89FGS',
        					 'car_colour' => 'Silver',
        					 'passengers' => 5]);
        }

    }

}

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('USER')->delete();

        User::create(['email'       => 't.mihalis@gmail.com', 
                      'password'    => '69%79205634!',
                      'title'       => 'Mr',  
                      'firstname'   => 'Michael',
                      'lastname'    => 'Tsilikidis',
                      'mobile'      => '07932019794',
                      'is_admin'    => 'Y']);

        User::create(['email'       => 'jimkavouris4@gmail.com ', 
                      'password'    => '$2y$10$ze/RuvYcBc81.dZ/ojBZ9e5rbRngq..nRwOtOiET5EBrJMq17kMTi',
                      'title'       => 'Mr',  
                      'firstname'   => 'Dimitris',
                      'lastname'    => 'Kavouris',
                      'is_admin'    => 'Y']);

    }

}

class TranslationTableSeeder extends Seeder {

    public function run()
    {
        DB::table('TRANSLATION')->delete();

        Translation::create(['locale' => 'el', 'column_name' => 'firstname', 'value' => 'Όνομα',    'table_name' => 'FIELD', 'identifier' => '2']);
        Translation::create(['locale' => 'el', 'column_name' => 'lastname', 'value' => 'Επώνυμο',  'table_name' => 'FIELD', 'identifier' => '3']);
        Translation::create(['locale' => 'el', 'column_name' => 'mobile',   'value' => 'Κινητό',   'table_name' => 'FIELD', 'identifier' => '4']);
        Translation::create(['locale' => 'el', 'column_name' => 'landline', 'value' => 'Τηλέφωνο', 'table_name' => 'FIELD', 'identifier' => '5']);
        Translation::create(['locale' => 'el', 'column_name' => 'email',    'value' => 'E-mail',   'table_name' => 'FIELD', 'identifier' => '6']);
        Translation::create(['locale' => 'el', 'column_name' => 'carmake',  'value' => 'Μάρκα οχήματος', 'table_name' => 'FIELD', 'identifier' => '7']);
        Translation::create(['locale' => 'el', 'column_name' => 'carmodel', 'value' => 'Μοντέλο',  'table_name' => 'FIELD', 'identifier' => '8']);
        Translation::create(['locale' => 'el', 'column_name' => 'carreg',   'value' => 'Αρ. Κυκλοφορίας',  'table_name' => 'FIELD', 'identifier' => '9']);
        Translation::create(['locale' => 'el', 'column_name' => 'carcolour', 'value' => 'Χρώμα οχήματος', 'table_name' => 'FIELD', 'identifier' => '10']);
        Translation::create(['locale' => 'el', 'column_name' => 'passengers', 'value' => 'Θέσεις επιβατών', 'table_name' => 'FIELD', 'identifier' => '11']);

        Translation::create(['locale' => 'el', 'column_name' => 'attributes', 'value' => '{"Κος":"Κος","Κα":"Κα"}', 'table_name' => 'FIELD', 'identifier' => '1']);
        Translation::create(['locale' => 'el', 'column_name' => 'name', 'value' => 'Τίτλος', 'table_name' => 'FIELD', 'identifier' => '1']);

    }

}

class ConfigurationTableSeeder extends Seeder {

    public function run()
    {
        DB::table('CONFIGURATION')->delete();

        Configuration::create(['parking_id' => 1, 'conf_name' => 'CANCELLATIONS',    'value' => 'Y']);
        Configuration::create(['parking_id' => 1, 'conf_name' => 'CANCEL_THRESHOLD', 'value' => '24']);

    }

}

class TagsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('TAGS')->delete();

        Tag::create(['name' => 'Open 24 hours',         'icon_filename' => '24_hour.png']);
        Tag::create(['name' => 'Undercover Parking',    'icon_filename' => 'undercover.png']);
        Tag::create(['name' => 'Garage',                'icon_filename' => 'garage.png']);
        Tag::create(['name' => 'Parking for Disabled',  'icon_filename' => 'disabled.png']);
        Tag::create(['name' => 'Secure',                'icon_filename' => 'secured.png']);
        Tag::create(['name' => 'Well-Lit',              'icon_filename' => 'light.png']);
        Tag::create(['name' => 'Free Transfers',        'icon_filename' => 'taxi.png']);
        Tag::create(['name' => 'Meet & Greet Service',  'icon_filename' => 'meet.png']);
        Tag::create(['name' => 'Keep your Car Keys',    'icon_filename' => 'keys.png']);
        Tag::create(['name' => 'Insured Car Park',      'icon_filename' => 'insured.png']);
        Tag::create(['name' => 'Insured Drivers',       'icon_filename' => 'insured_drivers.png']);
        Tag::create(['name' => 'Perimeter Fence',       'icon_filename' => 'fence.png']);
        Tag::create(['name' => 'Barrier Entry',         'icon_filename' => 'barrier.png']);
        Tag::create(['name' => 'CCTV Cameras',          'icon_filename' => 'cctv.png']);
        Tag::create(['name' => 'Car Wash Service',      'icon_filename' => 'car_wash.png']);
        Tag::create(['name' => 'Cots Available',        'icon_filename' => 'cots.png']);
        Tag::create(['name' => 'Carry my Luggage Service', 'icon_filename' => 'carry_luggage.png']);
        Tag::create(['name' => 'Charge my Battery Service', 'icon_filename' => 'battery.png']);
        Tag::create(['name' => 'Guard Dog on Site',     'icon_filename' => 'dog.png']);
        Tag::create(['name' => 'Toilet',                'icon_filename' => 'wc.png']);
        Tag::create(['name' => 'Wi-Fi',                 'icon_filename' => 'wifi.png']);
    }

}

class ParkingTagTableSeeder extends Seeder {

    public function run()
    {
        DB::table('PARKING_TAG')->delete();

        ParkingTag::create(['parking_id' => 1, 'tag_id' => 1]);
    }

}