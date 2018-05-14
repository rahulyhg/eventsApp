<?php
/**
 * Created by PhpStorm.
 * User: fabrizio
 * Date: 06/05/18
 * Time: 22:34
 */

namespace App\Controllers;

use Respect\Validation\Exceptions\FalseValException;
use Respect\Validation\Validator as v;

class SubscriptionController extends Controller
{
    public function getEventSubscriptionCreate($request, $response, $args)
    {
        $form = $this->form->getFields('EventSubscription')->createSet();

        return $this->view->render($response, 'controller/subscription/event.html.twig',
          [
            'form_title'  => 'Event subscription',
            'form_submit' => 'Subscribe me!',
            'form_action' => 'event.subscription.create',
            'form' => $form,
          ]
        );
    }

    public function postEventSubscriptionCreate($request, $response)
    {
        $uploadedFiles =  $request->getUploadedFiles();
        $uploadedFile  =  $uploadedFiles['abstract_file'];
        $filename      =  $uploadedFile->getClientFilename();
        $application   =  $request->getParam('abstract_apply');
        $abstract      =  true;

        if (null != $filename || $application) {

            // File extensions.
            $file_validation = v::oneOf(
              v::extension('pdf'),
              v::extension('doc'),
              v::extension('docx')
            )->validate($filename);

            // File apply for.
            $apply_validation = v::notEmpty()->validate($application);

            // Validate extensions.
            if (!$file_validation) {
                $this->validator->setCustomErrors(
                  'abstract_file',
                  'Please check the abstract file. Make sue the extension is on of the following: pdf, doc, docx'
                );
                $abstract = false;
            }

            // Validate application.
            if (!$apply_validation) {
                $this->validator->setCustomErrors(
                  'abstract_apply',
                  'Please select the application of the file.'
                );
                $abstract = false;
            }
        }

        // Validate accommodation.
        $validation = $this->validator->validate($request, ['accommodations' => v::notEmpty()]);
        if ($validation->failed() || !$abstract) {
            return $response->withRedirect($this->router->pathFor('event.subscription.create'));
        }

        // ELSE SUBSCRIBE USER ...
        //return $response->withRedirect($this->router->pathFor('event.subscription.create'));
    }

    public function getEventSubscriptionUpdate($request, $response, $args) {

    }

    public function postEventSubscriptionUpdate($request, $response) {

    }

    public function getMeetupSubscriptionCreate($request, $response, $args) {

    }

    public function postMeetupSubscriptionCreate($request, $response) {

    }
}