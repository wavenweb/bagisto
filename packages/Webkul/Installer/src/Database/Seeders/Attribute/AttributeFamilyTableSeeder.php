<?php

namespace Webkul\Installer\Database\Seeders\Attribute;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeFamilyTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @param  array  $parameters
     * @return void
     */
    public function run($parameters = [])
    {
        $databaseDriver = config('database.default');

        if ($databaseDriver == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        } elseif ($databaseDriver == 'pgsql') {
            // Use SET CONSTRAINTS instead of session_replication_role
            DB::statement('SET CONSTRAINTS ALL DEFERRED;');
        }

        DB::table('attribute_families')->delete();

        $defaultLocale = $parameters['default_locale'] ?? config('app.locale');

        DB::table('attribute_families')->insert([
            [
                'id'              => 1,
                'code'            => 'default',
                'name'            => trans('installer::app.seeders.attribute.attribute-families.default', [], $defaultLocale),
                'status'          => 0,
                'is_user_defined' => 1,
            ],
        ]);

        if ($databaseDriver == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } elseif ($databaseDriver == 'pgsql') {
            // Use SET CONSTRAINTS instead of session_replication_role
            DB::statement('SET CONSTRAINTS ALL IMMEDIATE;');
        }
    }
}
