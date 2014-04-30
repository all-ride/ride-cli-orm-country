<?php

namespace ride\cli\command\orm;

use ride\library\cli\command\AbstractCommand;
use ride\library\orm\OrmManager;
use ride\library\system\file\File;

/**
 * Command to define the models in the database
 */
class OrmImportCountriesCommand extends AbstractCommand {

    /**
     * Instance of the ORM
     * @var \ride\library\orm\OrmManager
     */
    protected $orm;

    /**
     * Path for the continent data files
     * @var \ride\library\system\file\File
     */
    protected $continentPath;

    /**
     * Path for the country data files
     * @var \ride\library\system\file\File
     */
    protected $countryPath;

    /**
     * Locales to install the data in
     * @var array
     */
    protected $locales;

    /**
     * Constructs a new orm define command
     * @return null
     */
    public function __construct(OrmManager $orm, File $continentPath, File $countryPath, array $locales) {
        parent::__construct('orm import countries', 'Imports the countries and continents in the database');

        $this->orm = $orm;
        $this->continentPath = $continentPath;
        $this->countryPath = $countryPath;
        $this->locales = $locales;
    }

    /**
     * Executes the command
     * @return null
     */
    public function execute() {
        $continentModel = $this->orm->getContinentModel();
        $countryModel = $this->orm->getCountryModel();

        $continents = $continentModel->installContinents($this->continentPath, $this->locales);
        $countryModel->installCountries($this->countryPath, $this->locales, $continents);
    }

}
