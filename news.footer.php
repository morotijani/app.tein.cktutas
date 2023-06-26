    </main>

    <footer class="py-5 text-center text-body-secondary bg-body-tertiary">
        <p>Members registration and news feed built for <a href="<?= PROOT; ?>">TEIN - CKTUTAS</a> by <a href="https://twitter.com/teincktutas">@IT_COMMITTEE</a>.</p>
        <p class="mb-0">
            <a href="#">Back to top</a>
        </p>
    </footer>

    <!-- SUBSCRIBE MODAL -->
    <div class="modal fade" id="subscribeModal" tabindex="-1" aria-labelledby="subscribeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form method="POST" action="<?= PROOT; ?>news/subscriber">
                    <div class="modal-body">
                        <p class="card-text">Subscribe to our news letter for daily update of news.</p>
                            <div class="form-floating mb-2">
                                <input type="email" id="subscriber_email" name="subscriber_email" autocomplete="nope" class="form-control" placeholder="Email" required>
                                <label>Email</label>
                                <div class="form-text">Your data or information are saved with us. It never be shared to any third party.</div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- search modal -->
    <div class='modal fade' id='searchModal' tabindex='-1' aria-labelledby='searchModalLabel' aria-hidden='true'>
        <div class='modal-dialog modal-dialog-centered'>
            <div class='modal-content'>
                <div class='modal-body'>
                    <form method="GET" action="<?= PROOT; ?>news/search">
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" id="q" placeholder="Enter search">
                            <button class="btn btn-outline-secondary">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= PROOT; ?>assets/js/jquery-3.6.0.js"></script>
    <script src="<?= PROOT; ?>assets/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
    
</body>
</html>
