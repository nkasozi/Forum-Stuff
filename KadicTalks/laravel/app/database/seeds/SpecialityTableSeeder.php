<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SpecialityTableSeeder
 *
 * @author ken
 */
class SpecialityTableSeeder extends Seeder
{
  public function run()
    {
        $now = date('Y-m-d H:i:s');
        DB::table('specialities')->delete();
        
        $specialities=array(
            'Andrologist',
            'Anesthesiologist',
            'Allergist',
            'Audiologist',
            'Cardiologist',
            'Dentist',
            'Dermatologist',
            'Endocrinologist',
            'Epidemiologist',
            'Family Practician',
            'Gastroenterologist',
            'Gynecologist',
            'Hematologist',
            'Hepatologist',
            'Immunologist',
            'Infectious Disease Specialist',
            'Internal Medicine Specialist',
            'Internist',
            'Medical Geneticist',
            'Microbiologist',
            'Neonatologist',
            'Nephrologist',
            'Neurologist',
            'Neurosurgeon',
            'Nurse',
            'Obstetrician',
            'Oncologist',
            'Ophthalmologist',
            'Orthopedic Surgeon',
            'ENT specialist',
            'Perinatologist',
            'Paleopathologist',
            'Parasitologist',
            'Pathologist',
            'Pediatrician',
            'Physiologist',
            'Physiatrist',
            'Plastic Surgeon',
            'Podiatrist',
            'Psychiatrist',
            'Pulmonologist',
            'Radiologist',
            'Rheumatologsist',
            'Surgeon',
            'Urologist',
            'Emergency Doctor',
        );
        
        foreach ($specialities as $speciality)
        {
           Speciality::create(array(
           'speciality'=>$speciality,
            'created_at' => $now,
            'updated_at' => $now
        ));
        }    
    }
}
