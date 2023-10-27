<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('scan-ok', Msg => {})

        @this.on('scan-notfound', Msg => {})

        @this.on('no-stock', Msg => {})

        @this.on('sale-error', Msg => {})

        @this.on('print-ticket', SaleId => {
            window.open("print://" + saleId, '_blank')
        })

    });
</script>
