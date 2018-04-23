
// function allSearch(){
//     searchpredict();
// }


var site = "../";

function searchpredict(){

    // var site = "<?php echo base_url();?>";

    // 1 - 2 - 3 - 4 - 5
    if(searchKRI && searchPESUD && searchPANGKALAN && searchMARINIR && searchSATGAS){
      console.log("KRI, PESUD, PANGKALAN, MARINIR, SATGAS");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/search'});
        
    // 1 - 2 - 3 - 4
    } if(searchKRI && searchPESUD && searchPANGKALAN && searchMARINIR && !searchSATGAS){
      console.log("KRI, PESUD, PANGKALAN, MARINIR");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchKriPesPangMar'});
        
    // 1 - 2 - 3 -5
    } if(searchKRI && searchPESUD && searchPANGKALAN && searchSATGAS && !searchMARINIR){
      console.log("KRI, PESUD, PANGKALAN, SATGAS");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchKriPesPangSat'});
        
    // 1 - 2 - 4 - 5
    } if(searchKRI && searchPESUD && searchMARINIR && searchSATGAS && !searchPANGKALAN){
      console.log("KRI, PESUD, MARINIR, SATGAS");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchKriPesMarSat'});
        
    // 1 - 3 - 4 - 5
    } if(searchKRI && searchPANGKALAN && searchMARINIR && searchSATGAS && !searchPESUD){
      console.log("KRI, PANGKALAN, MARINIR, SATGAS");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchKriPangMarSat'});
        
    // 2 - 3 - 4 - 5
    } if(searchPESUD && searchPANGKALAN && searchMARINIR && searchSATGAS && !searchKRI){
      console.log("PESUD, PANGKALAN, MARINIR, SATGAS");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchPesPangMarSat'});
        
    // 1 - 2 - 3
    } if(searchKRI && searchPESUD && searchPANGKALAN && !searchMARINIR && !searchSATGAS){
      console.log("KRI, PESUD, PANGKALAN");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchKriPesPang'});
        
    //1 - 2 - 4
    } if(searchKRI && searchPESUD && searchMARINIR && !searchPANGKALAN && !searchSATGAS){
        console.log("KRI, PESUD, MARINIR");
        $('.autocomplete').autocomplete('clearCache');
        $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchKriPesMar'});
        
    // 1 - 3 - 4
    } if(searchKRI && searchPANGKALAN && searchMARINIR && !searchSATGAS && !searchPESUD){
      console.log("KRI, PANGKALAN, MARINIR");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchKriPangMar'});
        
    // 2 - 3 - 4
    } if(searchPESUD && searchPANGKALAN && searchMARINIR && !searchKRI && !searchSATGAS){
      console.log("PESUD, PANGKALAN, MARINIR");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchPesPangMar'});
        
    // 1 - 2 - 5
    } if(searchKRI && searchPESUD && searchSATGAS && !searchPANGKALAN && !searchMARINIR ){
      console.log("KRI, PESUD, SATGAS");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchKriPesSat'});
        
    // 1 - 3 - 5
    } if(searchKRI && searchPANGKALAN && searchSATGAS && !searchMARINIR && !searchPESUD){
      console.log("KRI, PANGKALAN, SATGAS");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchKriPangSat'});
        
    // 1 - 4 - 5
    } if(searchKRI && searchMARINIR && searchSATGAS && !searchPESUD && !searchPANGKALAN ){
      console.log("KRI, MARINIR, SATGAS");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchKriMarSat'});
        
    // 2 - 3 - 5
    } if(searchPESUD && searchPANGKALAN && searchSATGAS && !searchMARINIR && !searchKRI){
      console.log("PESUD, PANGKALAN, SATGAS");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchPesPangSat'});
        
    // 2 - 4 - 5
    } if(searchPESUD && searchMARINIR && searchSATGAS && !searchKRI && !searchPANGKALAN){
      console.log("PESUD, MARINIR, SATGAS");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchPesMarSat'});
        
    // 3 - 4 - 5
    } if(searchPANGKALAN && searchMARINIR && searchSATGAS && !searchKRI && !searchPESUD){
      console.log("PANGKALAN, MARINIR, SATGAS");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchMarSat'});
        
    // 1 - 2
    } if(searchKRI && searchPESUD && !searchPANGKALAN && !searchMARINIR && !searchSATGAS ){
      console.log("KRI, PESUD");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchKriPes'});
        
        //1 - 3
    } if(searchKRI && searchPANGKALAN && !searchMARINIR && !searchSATGAS && !searchPESUD){
      console.log("KRI, PANGKALAN");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchKriPang'});
        
        //1 - 4
    } if(searchKRI && searchMARINIR && !searchSATGAS && !searchPESUD && !searchPANGKALAN){
      console.log("KRI, MARINIR");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchKriMar'});
        
        //1 - 5
    } if(searchKRI && searchSATGAS && !searchPESUD && !searchPANGKALAN && !searchMARINIR){
      console.log("KRI, SATGAS");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchKriSat'});
        
        //2 - 5
    } if(searchPESUD && searchSATGAS && !searchPANGKALAN && !searchKRI && !searchMARINIR){
      console.log("PESUD, SATGAS");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchPesSat'});
        
    //3 - 5
    } if(searchPANGKALAN && searchSATGAS && !searchMARINIR && !searchPESUD && !searchKRI){
      console.log("PANGKALAN, SATGAS");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchPangSat'});
        
    // 4 - 5
    } if(searchMARINIR && searchSATGAS && !searchPESUD && !searchPANGKALAN && !searchKRI){
      console.log("MARINIR, SATGAS");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchMarSat'});
        
    // 2 - 3
    } if(searchPESUD && searchPANGKALAN && !searchKRI && !searchSATGAS && !searchMARINIR){
      console.log("PESUD, PANGKALAN");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchPesPang'});

    // 2 - 4   
    } if(searchPESUD && searchMARINIR && !searchPANGKALAN && !searchKRI && !searchSATGAS){
      console.log("PESUD, MARINIR");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchPesMar'});

    // 3 - 4   
    } if(searchMARINIR && searchPANGKALAN && !searchKRI && !searchPESUD && !searchSATGAS){
      console.log("PANGKALAN, MARINIR");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchPangMar'});
        
    } if(searchKRI && !searchPESUD && !searchPANGKALAN && !searchMARINIR && !searchSATGAS){
      console.log("KRI");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchKRI'});

    } if(searchPESUD && !searchKRI && !searchPANGKALAN && !searchMARINIR && !searchSATGAS){
      console.log("PESUD");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchPESUD'});

    } if(searchPANGKALAN && !searchPESUD && !searchKRI && !searchMARINIR && !searchSATGAS){
      console.log("PANGKALAN");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchPANGKALAN'});

    } if(searchMARINIR && !searchPESUD && !searchPANGKALAN && !searchKRI && !searchSATGAS){
      console.log("MARINIR");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchMARINIR'});

    } if(searchSATGAS && !searchPESUD && !searchPANGKALAN && !searchMARINIR && !searchKRI){
      console.log("SATGAS");
      $('.autocomplete').autocomplete('clearCache');
      $('.autocomplete').autocomplete('setOptions', {serviceUrl: site + 'autocomplete/searchSATGAS'});

    } if(!searchSATGAS && !searchPESUD && !searchPANGKALAN && !searchMARINIR && !searchKRI){
      console.log("NOTHING");
      $('.autocomplete').autocomplete('clearCache');      

    }
}