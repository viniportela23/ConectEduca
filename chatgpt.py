import openai

# Configurar a chave da API OpenAI
openai.api_key = "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"

while True:
    # Verificar se há uma pergunta no arquivo pergunta.txt
    with open("pergunta.txt", "r", encoding="utf-8") as file:
        pergunta = file.readline().strip()

    if pergunta:
        # Chamar a API OpenAI e obter a resposta
        response = openai.Completion.create(
            engine="text-davinci-003",
            prompt=pergunta,
            max_tokens=100,
            n=1,
            stop=None,
            temperature=0.7,
        )

        resposta = response.choices[0].text.strip()

        # Salvar a resposta no arquivo resposta.txt
        with open("resposta.txt", "w", encoding="utf-8") as file:
            file.write(resposta)
            print("foi\n")

        # Limpar o conteúdo do arquivo pergunta.txt
        with open("pergunta.txt", "w", encoding="utf-8") as file:
            pass
