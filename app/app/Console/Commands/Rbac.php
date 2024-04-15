<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Yiisoft\Rbac\Manager;
use Yiisoft\Rbac\Permission;
use Yiisoft\Rbac\Role;
use Yiisoft\Rbac\Php\AssignmentsStorage;
use Yiisoft\Rbac\Php\ItemsStorage;
use Yiisoft\Rbac\Rules\Container\RulesContainer;
use App\Console\Commands\Rbac\Rules\AdminOrOwnerRule;
use App\Models\User;

class Rbac extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rbac:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init Role Based Access Control';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $directory = __DIR__ . '/../../../storage/rbac';

        $itemsStorage = new ItemsStorage($directory . '/items.php');
        $assignmentsStorage = new AssignmentsStorage($directory . '/assignments.php');
        $rulesContainer = new RulesContainer(app());

        $manager = new Manager($itemsStorage, $assignmentsStorage, $rulesContainer);

       // Post
        $manager->addPermission(new Permission('createPost'));
        $manager->addPermission((new Permission('updatePost'))->withRuleName(AdminOrOwnerRule::class));
        $manager->addPermission((new Permission('deletePost'))->withRuleName(AdminOrOwnerRule::class));

        // Roles
        $manager->addRole(new Role('author'));
        $manager->addRole(new Role('admin'));

        // author
        $manager->addChild('author', 'createPost');
        $manager->addChild('author', 'updatePost');
        $manager->addChild('author', 'deletePost');

        // the admin can do everything the author can
        $manager->addChild('admin', 'author');

        // assign users for their roles
        foreach (User::get() as $user) {
            $manager->assign(User::ROLE_CAPTION[$user->role], $user->id);
        }

        return 0;
    }
}
