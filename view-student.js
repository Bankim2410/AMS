var page = 1;
        var lastPage = false;

        $(document).ready(function(){
            fetchData(page);
        });

        function fetchData(page) {
            $.ajax({
                url: "get_students.php",
                type: "POST",
                data: {page: page},
                success: function(response) {
                    $('#students-info').html(response);
                    updateButtons();
                }
            });
        }

        function nextPage() {
            if (!lastPage) {
                page++;
                fetchData(page);
            }
        }

        function prevPage() {
            if (page > 1) {
                page--;
                fetchData(page);
            }
        }

        function updateButtons() {
            var hasNextPage = $('#students-info tr').length > 1; // Check if there are more than one rows in the table body

            if (page === 1) {
                $('#prevBtn').prop('disabled', true);
            } else {
                $('#prevBtn').prop('disabled', false);
            }

            $('#nextBtn').prop('disabled', !hasNextPage);
            lastPage = !hasNextPage;
        }