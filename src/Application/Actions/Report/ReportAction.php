<?php

namespace App\Application\Actions\Report;

use App\Application\Actions\Action;
use Dotenv\Dotenv;
use KirbyReporter\Client\GithubReport;
use KirbyReporter\Model\FormData;
use KirbyReporter\Vendor\Vendor;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class ReportAction extends Action
{
    public function __construct(LoggerInterface $logger)
    {
        parent::__construct($logger);
    }

    protected function action(): ResponseInterface
    {
        $dotenv = Dotenv::createUnsafeImmutable(dirname(__DIR__, 4));
        $dotenv->load();

        /** @noinspection PhpUnhandledExceptionInspection */
        /** @noinspection GlobalVariableUsageInspection */
        $vendor = new Vendor('https://github.com/gearsdigital/kirby-reporter-test', $_ENV['GITHUB_API_TOKEN']);
        $reporter = new GithubReport($vendor);
        $formData = new FormData($this->request->getParsedBody());
        $template = $formData->getFormFields()['description'];
        $response = $reporter->report($formData, $template);

        return $this->respondWithData($response);
    }
}
