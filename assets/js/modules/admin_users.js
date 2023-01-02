document.addEventListener('DOMContentLoaded', async () => {
    document.querySelectorAll('.user-delete').forEach((button) => {
        button.addEventListener('click', async (e) => {
            e.preventDefault()
            try{
                const response = await fetch("./api/admin/users", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        token : getCookie('token'),
                        user_id: e.target.value,
                        type: 'delete',
                    }),
                })
                const data = await response.json()
                if (data.status == 'success') {
                   e.target.parentElement.parentElement.parentElement.remove()
                } else {
                    console.log(data)
                }
            } catch (e) {
                console.log(e)
            }
        })
    })
})
