<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class FormController extends Controller
{
    /**
     * 
     */
    public function showForm()
    {
        $path = app()->basePath() . '/app/SetaPDF/Autoload.php';
        require($path);

        $filename = 'LogixAsForm2.pdf';
        $fieldValues = array(
            'FirstName' => 'Samir',
            'LastName' => 'Patel',
            'DOB' => '02/09/1984',
            'SSN' => '486196745',
            'HomeStreet' => '5421 Hickory Dr',
            'HomeCity' => 'Austin',
            'HomeState' => 'TX',
            'HomeZip' => '78744',
            'HomePhone' => '512-745-7846',
            'WorkPhone' => '512-745-7846',
            'IDState' => 'TX',
            'IDExpirationDate' => '07/18',
            'MailingStreet' => '5421 Hickory Dr',
            'MailingCity' => 'Austin',
            'MailingState' => 'TX',
            'MailingZip' => '78744',
        );
        $incrementalUpdate = true;
        $renderAppearance = true;
        $flatten = false;

        $writer = new \SetaPDF_Core_Writer_File('filledForm.pdf');
        $document = \SetaPDF_Core_Document::loadByFilename($filename, $writer);
        $formFiller = new \SetaPDF_FormFiller($document);

        if (!$flatten) {
            // set render appearance flag
            $formFiller->setNeedAppearances($renderAppearance);
        }
        $fields = $formFiller->getFields();

        foreach ($fieldValues AS $fieldName => $value) {
            $field = $fields->get($fieldName);

            // cast the value to the correct type
            if ($field instanceof \SetaPDF_FormFiller_Field_Combo) {
                $value = (int)$value;
            } else if ($field instanceof \SetaPDF_FormFiller_Field_Button) {
                if ($value == 1) {
                    $value = true;
                }
            } else if ($field instanceof \SetaPDF_FormFiller_Field_ButtonGroup) {
                $buttons = $field->getButtons();
                $value = $buttons[(int)$value];
            } else if ($field instanceof \SetaPDF_FormFiller_Field_List) {
                if (is_array($value)) {
                    $value = array_map('intval', $value);
                } else if (!is_null($value)) {
                    $value = (int)$value;
                }
            }

            $field->setValue($value);
        }

        if ($flatten) {
            $fields->flatten();
        }

        $document->save($incrementalUpdate)->finish();
        
        return view('welcome');
    }
}
