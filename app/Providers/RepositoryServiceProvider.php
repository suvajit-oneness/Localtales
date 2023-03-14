<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\BannerContract;
use App\Repositories\BannerRepository;
use App\Contracts\AdminContract;
use App\Contracts\BlogCategoryContract;
use App\Repositories\AdminRepository;
use App\Contracts\UserContract;
use App\Repositories\UserRepository;
use App\Contracts\BusinessContract;
use App\Repositories\BusinessRepository;
use App\Contracts\BussinessLeadContract;
use App\Repositories\BussinessLeadRepository;
use App\Contracts\CategoryContract;
use App\Repositories\CategoryRepository;
use App\Contracts\StateContract;
use App\Repositories\StateRepository;
use App\Contracts\PincodeContract;
use App\Repositories\PincodeRepository;
use App\Contracts\SuburbContract;
use App\Repositories\SuburbRepository;
use App\Contracts\SubCategoryContract;
use App\Repositories\SubCategoryRepository;
use App\Contracts\SubCategoryLevelContract;
use App\Repositories\SubCategoryLevelRepository;
use App\Contracts\DirectoryContract;
use App\Repositories\DirectoryRepository;
use App\Contracts\DirectoryCategoryContract;
use App\Repositories\DirectoryCategoryRepository;
use App\Contracts\CollectionContract;
use App\Repositories\CollectionRepository;
use App\Contracts\CollectionDirectoryContract;
use App\Repositories\CollectionDirectoryRepository;
use App\Contracts\EventContract;
use App\Repositories\EventRepository;
use App\Contracts\AboutContract;
use App\Repositories\AboutRepository;
use App\Contracts\ContactContract;
use App\Repositories\ContactRepository;
use App\Contracts\IndexContract;
use App\Repositories\IndexRepository;
use App\Contracts\FaqContract;
use App\Repositories\FaqRepository;
use App\Contracts\DealContract;
use App\Repositories\DealRepository;
use App\Contracts\PropertyContract;
use App\Repositories\PropertyRepository;
use App\Contracts\BlogContract;
use App\Repositories\BlogRepository;
use App\Contracts\EventRegistrationContract;
use App\Repositories\EventRegistrationRepository;
use App\Contracts\FaqModuleContract;
use App\Repositories\FaqModuleRepository;
use App\Contracts\SettingsContract;
use App\Repositories\SettingsRepository;
use App\Contracts\FrontCollectionContract;
use App\Repositories\FrontCollectionRepository;
use App\Contracts\NotificationContract;
use App\Repositories\NotificationRepository;
use App\Contracts\SearchContract;
use App\Repositories\SearchRepository;
use App\Contracts\DemoImageContract;
use App\Repositories\DemoImageRepository;
use App\Contracts\CategoryFaqContract;
use App\Repositories\CategoryFaqRepository;
use App\Contracts\LoopContract;
use App\Repositories\LoopRepository;
use App\Contracts\EventformatContract;
use App\Repositories\EventformatRepository;
use App\Contracts\LanguageContract;
use App\Models\DirectoryCategory;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\QueryRepository;
use App\Contracts\QueryContract;
use App\Contracts\HelpCategoryContract;
use App\Repositories\HelpCategoryRepository;
use App\Contracts\HelpSubCategoryContract;
use App\Repositories\HelpSubCategoryRepository;
use App\Contracts\HelpContract;
use App\Repositories\HelpRepository;
use App\Contracts\BlogFaqContract;
use App\Repositories\BlogFaqRepository;
use App\Contracts\BlogFaqCatContract;
use App\Repositories\BlogFaqCatRepository;
use App\Contracts\BlogFaqSubCatContract;
use App\Repositories\BlogFaqSubCatRepository;
use App\Contracts\DirectorySubCategoryContract;
use App\Repositories\DirectorySubCategoryRepository;
use App\Contracts\AdvocateRegistrationContract;
use App\Repositories\AdvocateRegistrationRepository;
use App\Contracts\JobCategoryContract;
use App\Repositories\JobCategoryRepository;
use App\Contracts\JobContract;
use App\Repositories\JobRepository;
use App\Contracts\NewsContract;
use App\Repositories\NewsRepository;
use App\Contracts\SchoolContract;
use App\Repositories\SchoolRepository;
use App\Contracts\DoctorContract;
use App\Repositories\DoctorRepository;
use App\Contracts\JobEmploymentTypeContract;
use App\Repositories\JobEmploymentTypeRepository;
class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        AdminContract::class              =>  AdminRepository::class,
        BannerContract::class             =>  BannerRepository::class,
        UserContract::class               =>  UserRepository::class,
        BusinessContract::class           =>  BusinessRepository::class,
        CategoryContract::class           =>  CategoryRepository::class,
        EventContract::class              =>  EventRepository::class,
        DealContract::class               =>  DealRepository::class,
        PropertyContract::class           =>  PropertyRepository::class,
        BlogContract::class               =>  BlogRepository::class,
        NotificationContract::class       =>  NotificationRepository::class,
        LoopContract::class               =>  LoopRepository::class,
        EventformatContract::class        =>  EventformatRepository::class,
        LanguageContract::class           =>  LanguageRepository::class,
        StateContract::class              =>     StateRepository::class,
        PincodeContract::class            =>   PincodeRepository::class,
        SuburbContract::class             =>         SuburbRepository::class,
        BlogCategoryContract::class       =>    BlogCategoryRepository::class,
        SubCategoryContract::class        =>        SubCategoryRepository::class,
        SubCategoryLevelContract::class   =>   SubCategoryLevelRepository::class,
        DirectoryContract::class          =>    DirectoryRepository::class,
        CollectionContract::class         =>     CollectionRepository::class,
        CollectionDirectoryContract::class => CollectionDirectoryRepository::class,
        DirectoryCategoryContract::class   =>   DirectoryCategoryRepository::class,
        BussinessLeadContract::class       =>        BussinessLeadRepository::class,
        SettingsContract::class            =>        SettingsRepository::class,
        AboutContract::class               =>        AboutRepository::class,
        ContactContract::class             =>        ContactRepository::class,
        FaqContract::class                 =>        FaqRepository::class,
        IndexContract::class               =>       IndexRepository::class,
        FaqModuleContract::class           =>       FaqModuleRepository::class,
        FrontCollectionContract::class     =>       FrontCollectionRepository::class,
        SearchContract::class              =>       SearchRepository::class,
        QueryContract::class               =>       QueryRepository::class,
        HelpCategoryContract::class        =>       HelpCategoryRepository::class,
        HelpSubCategoryContract::class     =>       HelpSubCategoryRepository::class,
        HelpContract::class                =>       HelpRepository::class,
        BlogFaqContract::class             =>       BlogFaqRepository::class,
        BlogFaqSubCatContract::class       =>       BlogFaqSubCatRepository::class,
        BlogFaqCatContract::class          =>       BlogFaqCatRepository::class,
        DemoImageContract::class           =>       DemoImageRepository::class,
        CategoryFaqContract::class         =>       CategoryFaqRepository::class,
        DirectorySubCategoryContract::class =>     DirectorySubCategoryRepository::class,
        AdvocateRegistrationContract::class =>     AdvocateRegistrationRepository::class,
        EventRegistrationContract::class    =>     EventRegistrationRepository::class,
        JobCategoryContract::class          =>     JobCategoryRepository::class,
        JobContract::class                  =>     JobRepository::class,
        JobEmploymentTypeContract::class    =>     JobEmploymentTypeRepository::class,
        NewsContract::class                 =>     NewsRepository::class,
        SchoolContract::class               =>     SchoolRepository::class,
        DoctorContract::class               =>     DoctorRepository::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $implementation)
        {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
