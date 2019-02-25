<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/2/22
 * Time: 下午 06:27
 */

namespace App\Events\Information\Notify;

use App\Constants\InformationCategory\InformationCategoryConstants;
use App\Constants\Lend\LendStatusConstants;
use App\Contract\Information\INotify;
use App\Models\LendRecord;

class LendRecordUpdated implements INotify
{
    /** @var LendRecord $orm */
    private $orm;
    /** @var string $subject */
    private $subject;

    /**
     * LendRecordUpdated constructor.
     * @param LendRecord $orm
     */
    public function __construct(LendRecord $orm)
    {
        $this->orm = $orm;
        $this->subject = ($this->orm->lend_state == LendStatusConstants::ACCEPT_CODE) ?
            "您的下发申请已通过" :
            "您的下发申请已被拒绝";
    }

    /**
     * 通知訊息的類別代碼
     * @return string
     * @see InformationCategoryConstants 回傳參數請參照 InformationCategoryConstants
     */
    public function getCategoryCode(): string
    {
        return InformationCategoryConstants::SYSTEM;
    }

    /**
     * 通知訊息標題
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * 通知訊息內容
     * @return string
     */
    public function getContent(): string
    {
        $note = !is_null($this->orm->review_note) ? "-备注:{$this->orm->review_note}" : null;
        $accountName = isset($this->orm->account) ? "-戶名:{$this->orm->account->name}" : null;
        $bankNumber = isset($this->orm->account) ? "-银行卡号:{$this->orm->account->account}" : null;
        $content = <<<CONTENT
        {$this->subject}
        -单号:{$this->orm->record_seq}
        {$accountName}
        {$bankNumber}
        -下发金额:{$this->orm->amount}
        {$note}
CONTENT;

        return $content;
    }

    /**
     * 通知個人
     * @return int|null
     */
    public function getUserId()
    {
        return $this->orm->user_id;
    }

    /**
     * 通知角色,若不需通知角色時,回傳空陣列
     * @return array
     * @see RolesConstants
     */
    public function getRoleSlug(): array
    {
        return [];
    }
}
