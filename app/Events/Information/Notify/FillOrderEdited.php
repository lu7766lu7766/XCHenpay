<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/2/23
 * Time: 下午 06:13
 */

namespace App\Events\Information\Notify;

use App\Constants\InformationCategory\InformationCategoryConstants;
use App\Contract\Information\INotify;
use App\Models\Authcode;

class FillOrderEdited implements INotify
{
    /** @var Authcode $data */
    private $data;
    /** @var string $subject */
    private $subject;
    /**
     * @var string $action
     */
    private $action;
    const ADD = 'add';
    const UPDATE = 'update';

    /**
     * FillOrderEdited constructor.
     * @param Authcode $data
     * @param string $action
     */
    public function __construct(Authcode $data, string $action)
    {
        $this->data = $data;
        $this->subject = "您有一笔补单" . $this->getActionMessage($action) . "通知，单号「(补){$this->data->trade_seq}」";
        $this->action = $action;
    }

    /**
     * @inheritdoc
     */
    public function getCategoryCode(): string
    {
        return InformationCategoryConstants::FILL_ORDER;
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
        return <<<EOT
您有一笔补单{$this->getActionMessage($this->action)}通知，请确认
- 单号: {$this->data->trade_seq}
EOT;
    }

    /**
     * @inheritdoc
     */
    public function getUserId()
    {
        return $this->data->company->getKey();
    }

    /**
     * @return array
     */
    public function getRoleSlug(): array
    {
        return [];
    }

    /**
     * @param string $action
     * @return string
     */
    public function getActionMessage(string $action)
    {
        $list = [
            self::ADD    => '新增',
            self::UPDATE => '状态更新'
        ];

        return $list[$action] ?? $action;
    }
}
