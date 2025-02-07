
<?php if (isset($attr['page']) && $attr['page'] == 'homeDeathNotice') { ?>

<div class="filter deathNotic home">
<form id="filterForm" class="filterForm" action="<?= home_url('death-notices') ?>">
    <div class="fieldParent" >
        <div class="field">
            <input type="text" name="first_name" value="<?= isset($_GET['first_name']) ? $_GET['first_name'] : '' ?>" placeholder="First Name">
        </div>
        <div class="field">
            <input type="text" name="surname" placeholder="Surname" value="<?= isset($_GET['surname']) ? $_GET['surname'] : '' ?>">
        </div>
        <!-- <div class="field">
            <input type="text" name="Nee" placeholder="nee">
        </div> -->
        <div class="field">
            <?php $irishCounties = [
                    'Antrim','Armagh','Carlow','Cavan','Clare','Cork','Derry','Donegal','Down','Dublin','Fermanagh','Galway','Kerry','Kildare','Kilkenny','Laois','Leitrim','Limerick','Longford','Louth','Mayo','Meath','Monaghan','Offaly','Roscommon','Sligo','Tipperary','Tyrone','Waterford','Westmeath','Wexford','Wicklow'
                ];
                // Get the county value from the URL
                $selectedCounty = isset($_GET['county']) ? $_GET['county'] : '';
            ?>
            <select name="county" id="county">
                <option selected hidden value="">Select County</option>

                <?php
                    foreach ($irishCounties as $county) {
                        // Check if the current county matches the one in the URL
                        $selected = ($county == $selectedCounty) ? 'selected' : '';
                        echo "<option value='".$county."' ".$selected.">".$county."</option>";

                    }
                ?>
            </select>
        </div>

        <div class="field">
            <?php $irishtown =['Belfast', 'Lisburn', 'Ballymena', 'Carrickfergus', 'Antrim','Armagh', 'Portadown', 'Lurgan', 'Craigavon','Carlow Town', 'Tullow', 'Bagenalstown', 'Hacketstown'];
            $selectedTown = isset($_GET['town']) ? $_GET['town'] : '';

            ?>
            <select name="town" id="town">
                <option selected hidden value="">Select Town</option>

                <?php
                    foreach ($irishtown as $county) {
                        // Check if the current county matches the one in the URL
                        $selected = ($county == $selectedTown) ? 'selected' : '';
                        echo "<option value='".$county."' ".$selected.">".$county."</option>";
                    }
                ?>
            </select>
        </div>

        <div class="field">
            <input type="date" name="from" value="<?= isset($_GET['from']) ? $_GET['from'] : date('Y-m-d', strtotime('-1 month')) ?>" max="<?= date('Y-m-d') ?>">
        </div>
        <div class="field">
            <input type="date" name="to" value="<?= isset($_GET['to']) ? $_GET['to'] : date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>">
        </div>

        <div class="field actionButton">
            <button type="submit">Search</button>
        </div>
    </div>
</form>
</div>

<?php } else if (isset($attr['page']) && $attr['page'] == 'deathNotic') { ?>

    <style>
        form#filterForm {
            width: 80%;
            display: table;
            margin: auto;
        }

        form#filterForm .field {
            width: 300px;
        }
    </style>
<div class="filter deathNotic">
    <form id="filterForm" class="filterForm">
        <div class="title">
            <h3>Search Death Notices</h3>
        </div>
        <div class="fieldParent" >
            <div class="field">
                <input type="text" name="first_name" value="<?= isset($_GET['first_name']) ? $_GET['first_name'] : '' ?>" placeholder="First Name">
            </div>
            <div class="field">
                <input type="text" name="surname" placeholder="Surname" value="<?= isset($_GET['surname']) ? $_GET['surname'] : '' ?>">
            </div>
            <!-- <div class="field">
                <input type="text" name="Nee" placeholder="nee">
            </div> -->
            <div class="field">
                <?php $irishCounties = [
                        'Antrim','Armagh','Carlow','Cavan','Clare','Cork','Derry','Donegal','Down','Dublin','Fermanagh','Galway','Kerry','Kildare','Kilkenny','Laois','Leitrim','Limerick','Longford','Louth','Mayo','Meath','Monaghan','Offaly','Roscommon','Sligo','Tipperary','Tyrone','Waterford','Westmeath','Wexford','Wicklow'
                    ];
                    // Get the county value from the URL
                    $selectedCounty = isset($_GET['county']) ? $_GET['county'] : '';
                ?>
                <select name="county" id="county">
                    <option selected hidden value="">Select County</option>

                    <?php
                        foreach ($irishCounties as $county) {
                            // Check if the current county matches the one in the URL
                            $selected = ($county == $selectedCounty) ? 'selected' : '';
                            echo "<option value='".$county."' ".$selected.">".$county."</option>";

                        }
                    ?>
                </select>
            </div>

            <div class="field">
                <?php $irishtown =['Belfast', 'Lisburn', 'Ballymena', 'Carrickfergus', 'Antrim','Armagh', 'Portadown', 'Lurgan', 'Craigavon','Carlow Town', 'Tullow', 'Bagenalstown', 'Hacketstown'];
                $selectedTown = isset($_GET['town']) ? $_GET['town'] : '';

                ?>
                <select name="town" id="town">
                    <option selected hidden value="">Select Town</option>

                    <?php
                        foreach ($irishtown as $county) {
                            // Check if the current county matches the one in the URL
                            $selected = ($county == $selectedTown) ? 'selected' : '';
                            echo "<option value='".$county."' ".$selected.">".$county."</option>";
                        }
                    ?>
                </select>
            </div>

            <!-- <div class="field">
                <input type="date" name="from" value="<?= isset($_GET['from']) ? $_GET['from'] : '' ?>" max="<?php date('Y-m-d')?>">
            </div>
            <div class="field">
                <input type="date" name="to" value="<?= isset($_GET['to']) ? $_GET['to'] : '' ?>" max="<?php date('Y-m-d')?>">
            </div> -->

            <div class="field">
                <input type="date" name="from" 
                    value="<?= isset($_GET['from']) ? $_GET['from'] : date('Y-m-d', strtotime('-1 month')) ?>" 
                    max="<?= date('Y-m-d') ?>">
            </div>
            <div class="field">
                <input type="date" name="to" 
                    value="<?= isset($_GET['to']) ? $_GET['to'] : date('Y-m-d') ?>" 
                    max="<?= date('Y-m-d') ?>">
            </div>

            <div class="field actionButton">
                <button type="submit">Search</button>
                <a href="<?= home_url('death-notices') ?>"><button type="button" class="clear_filter">Clear Filter 
                    <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="m12 10.586 4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636l4.95 4.95Z" fill="#ffffff"></path>
                    </svg>
                </button></a>
            </div>
        </div>
    </form>
</div>

<?php } else if (isset($attr['page']) && $attr['page'] == 'familyNotic') { ?>

    <style>
        form#filterForm .field {
            width: 200px;
        }
    </style>
    <div class="filter familyNotic">
    <form id="filterForm" class="filterForm">
        <div class="title">
            <h3>Search Family Notices</h3>
        </div>
        <div class="fieldParent" >
            <div class="field">
                <input type="text" name="first_name" value="<?= isset($_GET['first_name']) ? $_GET['first_name'] : '' ?>" placeholder="First Name">
            </div>
            <div class="field">
                <input type="text" name="surname" placeholder="Surname" value="<?= isset($_GET['surname']) ? $_GET['surname'] : '' ?>">
            </div>
            <!-- <div class="field">
                <input type="text" name="Nee" placeholder="nee">
            </div> -->
            <div class="field">
                <?php $irishCounties = [
                        'Antrim','Armagh','Carlow','Cavan','Clare','Cork','Derry','Donegal','Down','Dublin','Fermanagh','Galway','Kerry','Kildare','Kilkenny','Laois','Leitrim','Limerick','Longford','Louth','Mayo','Meath','Monaghan','Offaly','Roscommon','Sligo','Tipperary','Tyrone','Waterford','Westmeath','Wexford','Wicklow'
                    ];
                    // Get the county value from the URL
                    $selectedCounty = isset($_GET['county']) ? $_GET['county'] : '';
                ?>
                <select name="county" id="county">
                    <option selected hidden value="">Select County</option>

                    <?php
                        foreach ($irishCounties as $county) {
                            // Check if the current county matches the one in the URL
                            $selected = ($county == $selectedCounty) ? 'selected' : '';
                            echo "<option value='".$county."' ".$selected.">".$county."</option>";

                        }
                    ?>
                </select>
            </div>

            <div class="field">
                <?php $irishtown =['Belfast', 'Lisburn', 'Ballymena', 'Carrickfergus', 'Antrim','Armagh', 'Portadown', 'Lurgan', 'Craigavon','Carlow Town', 'Tullow', 'Bagenalstown', 'Hacketstown'];
                $selectedTown = isset($_GET['town']) ? $_GET['town'] : '';

                ?>
                <select name="town" id="town">
                    <option selected hidden value="">Select Town</option>

                    <?php
                        foreach ($irishtown as $county) {
                            // Check if the current county matches the one in the URL
                            $selected = ($county == $selectedTown) ? 'selected' : '';
                            echo "<option value='".$county."' ".$selected.">".$county."</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="field actionButton">
                <input type="hidden" name="cat_type" value="<?= isset($_GET['cat_type']) ? $_GET['cat_type'] : '' ?>">
                <button type="submit">Search</button>
                <a href="<?= home_url('family-notice') ?>"><button type="button" class="clear_filter">Clear Filter 
                    <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="m12 10.586 4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636l4.95 4.95Z" fill="#ffffff"></path>
                    </svg>
                </button></a>
            </div>
        </div>
    </form>
</div>

<?php } else { ?>

    <div class="filter servicesDirectory">
        <style>
            form#filterForm {
                width: fit-content;
                display: table;
                margin: 0 auto;
            }
        </style>
        <form id="filterForm" class="filterForm">
            <div class="title">
                <h3>Search For Service</h3>
            </div>
            <div class="fieldParent" >
                <div class="field">
                    <?php $irishCounties = [ 'Antrim','Armagh','Carlow','Cavan','Clare','Cork','Derry','Donegal','Down','Dublin','Fermanagh','Galway','Kerry','Kildare','Kilkenny','Laois','Leitrim','Limerick','Longford','Louth','Mayo','Meath','Monaghan','Offaly','Roscommon','Sligo','Tipperary','Tyrone','Waterford','Westmeath','Wexford','Wicklow' ]; ?>
                    <select name="county" id="county">
                    <option value='' disabled selected>County</option>
                        <?php
                            foreach ($irishCounties as $county) {
                                $selectedType = '';
                                if (isset($_GET['county'])) {
                                    $selectedType = $county == $_GET['county'] ? 'selected' : '';
                                }
                                echo "<option ".$selectedType." value='".$county."'>".$county."</option>";
                            }
                        ?>
                    </select>
                </div>

                <div class="field">
                    <?php 
                        $serviceType = [
                            "Funeral Directors",
                            "Crematoriums",
                            "Funeral Video Streaming",
                            "Funeral Car Hire",
                            "Florists",
                            "Bereavement Counsellors & Groups",
                            "Caterers",
                            "Headstones for Graves",
                            "Suit Hire",
                            "Funeral Celebrants/ Civil & Humanist Funerals",
                            "Singers & Musicians",
                            "Dove Hire",
                            "Grave Maintenance",
                            "Grave Markers, Plaques & Ornaments",
                            "Memorial Cards/Mass Cards",
                            "Urns & Keepsakes"
                        ];
                    ?>
                    <select name="type" id="service">
                        <option value='' disabled selected>Type Of Service</option>

                        <?php
                            foreach ($serviceType as $town) {
                                $selectedType = '';
                                $parameter = strtr($town, [" " => "-", "&" => "and"]);
                                if (isset($_GET['type'])) {
                                    $selectedType = $parameter == $_GET['type'] ? 'selected' : '';
                                }
                                echo "<option ".$selectedType." value='".$parameter."'>".$town."</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="field actionButton">
                    <button type="submit">Search</button>
                    <button type="button" class="clear_filter">Clear Filter 
                        <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="m12 10.586 4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636l4.95 4.95Z" fill="#ffffff"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </div>

<?php }  ?>