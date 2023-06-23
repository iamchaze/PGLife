<div class="filter-bar row justify-content-around">
    <div class="col-auto" data-toggle="modal" data-target="#filter-modal">
        <img src="img/filter.png" alt="filter" />
        <span>Filter</span>
    </div>
    <div class="col-auto">
        <img src="img/desc.png" alt="sort-desc" onclick="sortHighest()" />
        <span>Highest rent first</span>
    </div>
    <div class="col-auto">
        <img src="img/asc.png" alt="sort-asc" onclick="sortLowest()"/>
        <span>Lowest rent first</span>
    </div>
</div>
<div class="modal fade" id="filter-modal" tabindex="-1" role="dialog" aria-labelledby="filter-heading"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="filter-heading">Filters</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Gender</h5>
                <hr />
                <div>
                    <button class="btn btn-outline-dark btn-active" onclick="SetGender('nofilter')">
                        No Filter
                    </button>
                    <button class="btn btn-outline-dark" onclick="SetGender('unisex')">
                        <i class="fas fa-venus-mars"></i>Unisex
                    </button>
                    <button class="btn btn-outline-dark" onclick="SetGender('male')">
                        <i class="fas fa-mars"></i>Male
                    </button>
                    <button class="btn btn-outline-dark" onclick="SetGender('female')">
                        <i class="fas fa-venus"></i>Female
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    regex = /unisex|male|female/g
    removeRegex = /&gender=unisex|&gender=male|&gender=female/
    function SetGender(gender) {
        if (gender == 'nofilter') {
            window.location.href = window.location.href.replace(removeRegex, '')
        } else {
            var1 = window.location.href.indexOf('&gender')
            if (var1 == -1) {
                window.location.href = window.location.href + '&gender=' + gender;
            } else {
                window.location.href = window.location.href.replace(regex, gender)
            }
        }
    }
   
    function sortHighest(){
        var2 = window.location.href.indexOf("&sort=")
        if(var2 == -1){
            window.location.href = window.location.href + '&sort=' + 'DESC';
        } else {
            window.location.href = window.location.href.replace('ASC','DESC')
        }
    }
    function sortLowest(){
        var2 = window.location.href.indexOf("&sort=")
        if(var2 == -1){
            window.location.href = window.location.href + '&sort=' + 'ASC';
        } else {
            window.location.href = window.location.href.replace('DESC','ASC')
        }
    }
</script>