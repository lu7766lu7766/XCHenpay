<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/2/22
 * Time: 下午 05:36
 */

namespace App\Events\Information\Notify;

use App\Constants\Account\AccountStatusConstants;
use App\Constants\InformationCategory\InformationCategoryConstants;
use App\Contract\Information\INotify;
use App\Models\Account;

class AccountStatusUpdate implements INotify
{
    /** @var Account $data */
    private $data;
    /** @var string $subject */
    private $subject;

    /**
     * WhiteList constructor.
     * @param Account $data
     */
    public function __construct(Account $data)
    {
        $this->data = $data;
        $this->subject = $this->generateSubject();
    }

    /**
     * @inheritdoc
     */
    public function getCategoryCode(): string
    {
        return InformationCategoryConstants::TRANSACTION;
    }

    /**
     * @inheritdoc
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @inheritdoc
     */
    public function getContent(): string
    {
        $content = <<<EOT
您綁定的行卡{$this->getStatusMapping($this->data->status)}
- 开户名: {$this->data->name}
- 卡号: {$this->data->account}
- 银行名: {$this->data->bank_name}
- 开户支行: {$this->data->bank_branch}
EOT;
        if ($this->data->status == AccountStatusConstants::REJECT) {
            $content .= <<<EOT
            
- 备注: {$this->data->note}
EOT;
        }

        return $content;
    }

    /**
     * @inheritdoc
     */
    public function getUserId()
    {
        return $this->data->user_id;
    }

    /**
     * @return array
     */
    public function getRoleSlug(): array
    {
        return [];
    }

    /**
     * @return string
     */
    private function generateSubject()
    {
        return '您綁定的行卡' . $this->getStatusMapping($this->data->status) . '，卡号「' . $this->data->account . '」';
    }

    /**
     * @param string $status
     * @return string
     */
    private function getStatusMapping(string $status)
    {
        return ($status == AccountStatusConstants::APPROVAL) ? '已通过' : '未通过';
    }
}
