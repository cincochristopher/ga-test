<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSqlFunctions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // get_nested_where function
        $procedure = "
            DROP FUNCTION IF EXISTS `get_nested_where`;
            CREATE FUNCTION `get_nested_where`(`queryList` TEXT)
            RETURNS VARCHAR(10000)
            BEGIN 
                DECLARE pos INT DEFAULT 0; 
                DECLARE len INT DEFAULT 0;
                DECLARE fieldList varchar(8000) DEFAULT \"\"; 
                DECLARE nestedWhere varchar(8000) DEFAULT \"\";
                
                IF (queryList IS NOT NULL && queryList != '') THEN
                    SET queryList = CONCAT(queryList, '&');
                    
                    WHILE (LOCATE('&', queryList, pos+1) > 0) DO 
                      SET len = LOCATE('&', queryList, pos+1) - pos;
                      SET fieldList = format_query_params(SUBSTR(queryList, pos+1, len-1));
                      SET nestedWhere = CONCAT(nestedWhere, CONCAT(' AND ', fieldList));
                      SET pos = LOCATE('&', queryList, pos+len);
                    END WHILE; 
                    
                END IF;
                
                RETURN nestedWhere;
            END;
        ";

        DB::unprepared($procedure);

        $procedure = "
            DROP FUNCTION IF EXISTS `format_query_params`;
            CREATE FUNCTION `format_query_params`(`param` VARCHAR(100))
            RETURNS VARCHAR(255)
            BEGIN
                RETURN CONCAT(REPLACE(param, '=', \"='\"), \"'\");
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
        DB::unprepared("DROP FUNCTION IF EXISTS `get_nested_where`");
        DB::unprepared("DROP FUNCTION IF EXISTS `format_query_params`");
    }
}
