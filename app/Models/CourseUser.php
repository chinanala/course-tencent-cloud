<?php

namespace App\Models;

use Phalcon\Mvc\Model\Behavior\SoftDelete;

class CourseUser extends Model
{

    /**
     * 角色类型
     */
    const ROLE_STUDENT = 1; // 学员
    const ROLE_TEACHER = 2; // 讲师

    /**
     * 来源类型
     */
    const SOURCE_FREE = 1; // 免费
    const SOURCE_CHARGE = 2; // 付费
    const SOURCE_VIP = 3; // 会员
    const SOURCE_IMPORT = 4; // 导入

    /**
     * 主键编号
     *
     * @var int
     */
    public $id;

    /**
     * 课程编号
     *
     * @var int
     */
    public $course_id;

    /**
     * 用户编号
     *
     * @var int
     */
    public $user_id;

    /**
     * 计划编号
     *
     * @var int
     */
    public $plan_id;

    /**
     * 角色类型
     *
     * @var int
     */
    public $role_type;

    /**
     * 来源类型
     *
     * @var int
     */
    public $source_type;

    /**
     * 过期时间
     *
     * @var int
     */
    public $expiry_time;

    /**
     * 学习时长
     *
     * @var int
     */
    public $duration;

    /**
     * 学习进度
     *
     * @var int
     */
    public $progress;

    /**
     * 评价标识
     *
     * @var int
     */
    public $reviewed;

    /**
     * 删除标识
     *
     * @var int
     */
    public $deleted;

    /**
     * 创建时间
     *
     * @var int
     */
    public $create_time;

    /**
     * 更新时间
     *
     * @var int
     */
    public $update_time;

    public function getSource(): string
    {
        return 'kg_course_user';
    }

    public function initialize()
    {
        parent::initialize();

        $this->addBehavior(
            new SoftDelete([
                'field' => 'deleted',
                'value' => 1,
            ])
        );
    }

    public function beforeCreate()
    {
        $this->plan_id = (int)date('Ymd');

        $this->create_time = time();
    }

    public function beforeUpdate()
    {
        $this->update_time = time();
    }

    public static function roleTypes()
    {
        return [
            self::ROLE_STUDENT => '学员',
            self::ROLE_TEACHER => '讲师',
        ];
    }

    public static function sourceTypes()
    {
        return [
            self::SOURCE_FREE => '免费',
            self::SOURCE_CHARGE => '付费',
            self::SOURCE_VIP => '会员',
            self::SOURCE_IMPORT => '导入',
        ];
    }

}
