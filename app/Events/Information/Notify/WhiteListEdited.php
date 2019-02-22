<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/2/21
 * Time: 下午 05:32
 */

namespace App\Events\Information\Notify;

use App\Constants\InformationCategory\InformationCategoryConstants;
use App\Contract\Information\INotify;
use App\Models\Whitelist;

class WhiteListEdited implements INotify
{
    /** @var Whitelist $data */
    private $data;
    /** @var string $subject */
    private $subject;

    /**
     * WhiteList constructor.
     * @param Whitelist $data
     */
    public function __construct(Whitelist $data)
    {
        $this->data = $data;
        $this->subject = '您登入的白名单已被设置';
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
        $ipsContent = implode(",", $this->data->ip);

        return $this->subject . "-白名單IP:{$ipsContent}";
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
}
