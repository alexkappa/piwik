<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik;

use Exception;
use Piwik\Db\Adapter;
use Piwik\Db\Schema;

class DbHelper
{
    /**
     * Get list of tables installed
     *
     * @param bool $forceReload Invalidate cache
     * @return array  Tables installed
     */
    public static function getTablesInstalled($forceReload = true)
    {
        return Schema::getInstance()->getTablesInstalled($forceReload);
    }

    /**
     * Drop specific tables
     *
     * @param array $doNotDelete Names of tables to not delete
     */
    public static function dropTables($doNotDelete = array())
    {
        Schema::getInstance()->dropTables($doNotDelete);
    }

    /**
     * Returns true if Piwik is installed
     *
     * @since 0.6.3
     *
     * @return bool  True if installed; false otherwise
     */
    public static function isInstalled()
    {
        try {
            return Schema::getInstance()->hasTables();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Truncate all tables
     */
    public static function truncateAllTables()
    {
        Schema::getInstance()->truncateAllTables();
    }

    /**
     * Creates an entry in the User table for the "anonymous" user.
     */
    public static function createAnonymousUser()
    {
        Schema::getInstance()->createAnonymousUser();
    }

    /**
     * Create all tables
     */
    public static function createTables()
    {
        Schema::getInstance()->createTables();
    }

    /**
     * Drop database, used in tests
     */
    public static function dropDatabase()
    {
        if (defined('PIWIK_TEST_MODE') && PIWIK_TEST_MODE) {
            Schema::getInstance()->dropDatabase();
        }
    }

    /**
     * Check database connection character set is utf8.
     *
     * @return bool  True if it is (or doesn't matter); false otherwise
     */
    public static function isDatabaseConnectionUTF8()
    {
        return Db::get()->isConnectionUTF8();
    }

    /**
     * Checks the database server version against the required minimum
     * version.
     *
     * @see config/global.ini.php
     * @since 0.4.4
     * @throws Exception if server version is less than the required version
     */
    public static function checkDatabaseVersion()
    {
        Db::get()->checkServerVersion();
    }

    /**
     * Disconnect from database
     */
    public static function disconnectDatabase()
    {
        Db::get()->closeConnection();
    }

    /**
     * Create database
     *
     * @param string|null $dbName
     */
    public static function createDatabase($dbName = null)
    {
        Schema::getInstance()->createDatabase($dbName);
    }

    /**
     * Get the SQL to create Piwik tables
     *
     * @return array  array of strings containing SQL
     */
    public static function getTablesCreateSql()
    {
        return Schema::getInstance()->getTablesCreateSql();
    }

    /**
     * Get the SQL to create a specific Piwik table
     *
     * @param string $tableName
     * @return string  SQL
     */
    public static function getTableCreateSql($tableName)
    {
        return Schema::getInstance()->getTableCreateSql($tableName);
    }
}
