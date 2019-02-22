<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/2/21
 * Time: 下午 04:48
 */

namespace App\Contract\Information;

interface INotify
{
    /**
     * 通知訊息的類別代碼
     * @return string
     * @see InformationCategoryConstants 回傳參數請參照 InformationCategoryConstants
     */
    public function getCategoryCode(): string;

    /**
     * 通知訊息標題
     * @return string
     */
    public function getSubject(): string;

    /**
     * 通知訊息內容
     * @return string
     */
    public function getContent(): string;

    /**
     * 通知個人
     * @return int|null
     */
    public function getUserId();

    /**
     * 通知角色,若不需通知角色時,回傳空陣列
     * @return array
     * @see RolesConstants
     */
    public function getRoleSlug(): array;
}
