db.note.insert( [
    {
        "title": "Example note",
        "content": "This is just an example"
    },
    {
        "title" : "Christmas",
        "content" : "All I want is a good grade in online multimedia. And a boombox."
    }
] )

db.note.find({title: "Christmas"})

db.note.update({title: "Christmas"},{$set:{content: "All I want is world peace!"}})

db.note.remove({title: "Example note"})