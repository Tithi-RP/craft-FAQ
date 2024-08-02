<?php

namespace faqmanage\craftfaq\controllers;

use craft\web\Controller;
use faqmanage\craftfaq\services\FaqService;

use Craft;
use faqmanage\craftfaq\models\Faq;
use faqmanage\craftfaq\Plugin as FaqPlugin;
use Yii;
use yii\web\Response;

class FaqController extends Controller
{

    public function actionIndex(): Response
    {
        $faqs = FaqPlugin::$plugin->faqService->getAllFaqs();

        return $this->renderTemplate('faq/index', [
            'title' => 'FAQ Manager',
            'faqs' => $faqs
        ]);
    }


    public function actionEdit($faqId = null): Response
    {
        $faq = $faqId ? FaqService::getFaqById($faqId) : new Faq();

        return $this->renderTemplate('faq/edit', [
            'title' => 'Edit FAQ',
            'faq' => $faq,
        ]);
    }

    public function actionSaveFaq(): Response
    {

        $data = Yii::$app->request->post();

        // Create a new Faq model or fetch the existing one if an ID is provided
        if(!empty($data['id'])){
            $faqId = $data['id'];
            if ($faqId) {
                $faq = FaqService::getFaqById($faqId);
                if (!$faq) {
                    throw new \yii\web\NotFoundHttpException("FAQ not found");
                }
            } 
        }
        else {
            $faq = new Faq();
        }

        $faq->question = $data['question'] ?? "";
        $faq->answer = $data['answer'] ?? "";
        $faq->type =  $data['type'] ?? "TEST";

        if (FaqService::saveFaq($faq)) {
            Craft::$app->getSession()->setNotice('FAQ saved.');
        } else {
            Craft::$app->getSession()->setError('Couldn’t save FAQ.');
        }

        return $this->redirect('faq');
    }

    public function actionDelete($faqId = null): Response
    {
        if ($faqId) {
            $faq = FaqService::getFaqById($faqId);

            if ($faq && FaqService::deleteFaqById($faqId)) {
                Craft::$app->getSession()->setNotice('FAQ deleted.');
            } else {
                Craft::$app->getSession()->setError('Couldn’t delete FAQ.');
            }
        } else {
            Craft::$app->getSession()->setError('Invalid FAQ ID.');
        }
        return $this->redirect('faq');
    }
}
