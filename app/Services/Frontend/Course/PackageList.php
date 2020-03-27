<?php

namespace App\Services\Frontend\Course;

use App\Repos\Course as CourseRepo;
use App\Repos\Package as PackageRepo;
use App\Services\Frontend\CourseTrait;
use App\Services\Frontend\Service;
use Phalcon\Mvc\Model\Resultset;

class PackageList extends Service
{

    use CourseTrait;

    public function getPackages($id)
    {
        $course = $this->checkCourse($id);

        $courseRepo = new CourseRepo();

        $packages = $courseRepo->findPackages($course->id);

        return $this->handlePackages($packages);
    }

    /**
     * @param Resultset $packages
     * @return array
     */
    protected function handlePackages($packages)
    {
        if ($packages->count() == 0) {
            return [];
        }

        $result = [];

        foreach ($packages as $package) {

            $courses = $this->getPackageCourses($package->id);

            $result[] = [
                'id' => $package->id,
                'title' => $package->title,
                'market_price' => $package->market_price,
                'vip_price' => $package->vip_price,
                'courses' => $courses,
            ];
        }

        return $result;
    }

    protected function getPackageCourses($packageId)
    {
        $packageRepo = new PackageRepo();

        $courses = $packageRepo->findCourses($packageId);

        $result = [];

        $imgBaseUrl = kg_img_base_url();

        foreach ($courses as $course) {

            $course->cover = $imgBaseUrl . $course->cover;

            $result[] = [
                'id' => $course->id,
                'title' => $course->title,
                'cover' => $course->cover,
                'summary' => $course->summary,
                'market_price' => $course->market_price,
                'vip_price' => $course->vip_price,
                'model' => $course->model,
                'level' => $course->level,
            ];
        }

        return $result;
    }

}