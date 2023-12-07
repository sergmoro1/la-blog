<?php

namespace Tests;

use Illuminate\Support\Facades\DB;

class BlogTestCase extends TestCase
{
    public function clearTables()
    {
        DB::table('images')->delete();
        DB::table('post_tags')->delete();
        DB::table('tags')->delete();
        DB::table('posts')->delete();
        DB::table('users')->delete();
    }
}
