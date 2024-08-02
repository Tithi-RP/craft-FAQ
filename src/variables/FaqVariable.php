<?php
namespace faqmanage\craftfaq\variables;

use faqmanage\craftfaq\Plugin;

class FaqVariable
{
    public function getFaqById(int $faqId)
    {
        return Plugin::getInstance()->faqService->getFaqById($faqId);
    }
}
