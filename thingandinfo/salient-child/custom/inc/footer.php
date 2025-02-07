    <footer class="footer-wrapper"></footer>



    <script src="assets/front/js/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="assets/front/js/custom.js"></script>
    <script>
    	$('#myTable').DataTable( {
    		responsive: true,
    		paging: false,
    		scrollCollapse: true,
    		scrollY: '550px'    
    	} );


    	$(".drop_dwon_nav").click(function(){
    		$(this).toggleClass("collapsed");
    		$(".drop_dwon_list").slideToggle();
    	});
    </script>
</body>	`
</html>