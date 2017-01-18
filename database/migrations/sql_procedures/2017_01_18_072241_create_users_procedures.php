<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersProcedures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // get_users PROCEDURE
        $procedure = "
            DROP PROCEDURE IF EXISTS `get_users`;
            CREATE PROCEDURE `get_users`(`params` TEXT)
            BEGIN
                DECLARE sql_query TEXT DEFAULT \"SELECT * FROM users WHERE 1 \";
                
                SET @sql_query = CONCAT(sql_query, get_nested_where(params));
                
                PREPARE query_statement FROM @sql_query;
                EXECUTE query_statement;
                DEALLOCATE PREPARE query_statement;
            END;
        ";

        DB::unprepared($procedure);

        // get_user_by_id PROCEDURE
        $procedure = "
            DROP PROCEDURE IF EXISTS `get_user_by_id`;
            CREATE PROCEDURE `get_user_by_id`(`user_id` INT, `params` TEXT)
            BEGIN
                DECLARE sql_query VARCHAR(1000);
    
                SET @sql_query = CONCAT(\"SELECT * FROM users WHERE id = \", user_id, get_nested_where(params));
                
                PREPARE query_statement FROM @sql_query;
                EXECUTE query_statement;
                DEALLOCATE PREPARE query_statement;
            END;
        ";

        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS `get_user_by_id`");
        DB::unprepared("DROP PROCEDURE IF EXISTS `get_users`");
    }
}
