<?php require_once '../views/layouts/main.php'; ?>

<div class="container">
    <h1>Library Books</h1>
    <a href="index.php?controller=book&action=create" class="btn">Add New Book</a>
    
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Available</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($books)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['author']); ?></td>
                    <td><?php echo htmlspecialchars($row['isbn']); ?></td>
                    <td><?php echo htmlspecialchars($row['available_quantity']); ?></td>
                    <td>
                        <a href="index.php?controller=book&action=edit&id=<?php echo $row['id']; ?>">Edit</a>
                        <a href="index.php?controller=book&action=delete&id=<?php echo $row['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
