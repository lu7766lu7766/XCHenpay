<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2018/11/1
 * Time: 上午 11:21
 */

namespace App\Service;

use App\Http\Requests\SearchReportQueryRequest;
use App\Http\Requests\SearchReportStatQueryRequest;
use App\Repositories\AuthCodes;
use App\Traits\Pattern\Singleton;
use Illuminate\Validation\ValidationException;

class SearchService
{
    use Singleton;
    /**
     * @var array
     */
    protected $data;

    protected function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * 報表查詢(資料)
     * @return array
     */
    public function reportQuery()
    {
        $result = null;
        try {
            $handle = SearchReportQueryRequest::getHandle($this->data);
            $report = app(AuthCodes::class)->getReportRecord($handle->getStartDate(), $handle->getEndDate());
            $result = ["code" => 200, "data" => $report];
        } catch (ValidationException $e) {
            $result = ["code" => 1000, "data" => $e->validator->getMessageBag()->getMessages()];
        } catch (\Throwable $e) {
            $result = ["code" => 1001, "data" => []];
        }

        return $result;
    }

    /**
     * 報表統計(資料)
     * @param string $companyServiceId
     * @return array|null
     */
    public function reportStatQuery(string $companyServiceId)
    {
        $result = null;
        try {
            $handle = SearchReportStatQueryRequest::getHandle($this->data);
            $report = app(AuthCodes::class)
                ->getReportRecord($handle->getStartDate(), $handle->getEndDate(), $companyServiceId);
            $result = ["code" => 200, "data" => $report];
        } catch (ValidationException $e) {
            $result = ["code" => 1000, "data" => $e->validator->getMessageBag()->getMessages()];
        } catch (\Throwable $e) {
            $result = ["code" => 1001, "data" => []];
        }

        return $result;
    }
}
