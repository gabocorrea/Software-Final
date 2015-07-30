/**
 * Decorates another <code>Set</code> to ensure that the order of addition
 * is retained and used by the iterator.
 * <p>
 * If an object is added to the set for a second time, it will remain in the
 * original position in the iteration.
 * The order can be observed from the set via the iterator or toArray methods.
 * <p>
 * The ListOrderedSet also has various useful direct methods. These include many
 * from <code>List</code>, such as <code>get(int)</code>, <code>remove(int)</code>
 * and <code>indexOf(int)</code>. An unmodifiable <code>List</code> view of
 * the set can be obtained via <code>asList()</code>.
 * <p>
 * This class cannot implement the <code>List</code> interface directly as
 * various interface methods (notably equals/hashCode) are incompatable with a set.
 * <p>
 * This class is Serializable from Commons Collections 3.1.
 *
 * @since Commons Collections 3.0
 * @version $Revision: 966327 $ $Date: 2010-07-21 19:39:49 +0200 (Wed, 21 Jul 2010) $
 *
 * @author Stephen Colebourne
 * @author Henning P. Schmiedehausen
 */
/** Serialization version */
/** Internal list to hold the sequence of objects */
/**
     * Factory method to create an ordered set specifying the list and set to use.
     * <p>
     * The list and set must both be empty.
     *
     * @param set  the set to decorate, must be empty and not null
     * @param list  the list to decorate, must be empty and not null
     * @throws IllegalArgumentException if set or list is null
     * @throws IllegalArgumentException if either the set or list is not empty
     * @since Commons Collections 3.1
     */
/**
     * Factory method to create an ordered set.
     * <p>
     * An <code>ArrayList</code> is used to retain order.
     *
     * @param set  the set to decorate, must not be null
     * @throws IllegalArgumentException if set is null
     */
/**
     * Factory method to create an ordered set using the supplied list to retain order.
     * <p>
     * A <code>HashSet</code> is used for the set behaviour.
     * <p>
     * NOTE: If the list contains duplicates, the duplicates are removed,
     * altering the specified list.
     *
     * @param list  the list to decorate, must not be null
     * @throws IllegalArgumentException if list is null
     */
//-----------------------------------------------------------------------
/**
     * Constructs a new empty <code>ListOrderedSet</code> using
     * a <code>HashSet</code> and an <code>ArrayList</code> internally.
     *
     * @since Commons Collections 3.1
     */
/**
     * Constructor that wraps (not copies).
     *
     * @param set  the set to decorate, must not be null
     * @throws IllegalArgumentException if set is null
     */
/**
     * Constructor that wraps (not copies) the Set and specifies the list to use.
     * <p>
     * The set and list must both be correctly initialised to the same elements.
     *
     * @param set  the set to decorate, must not be null
     * @param list  the list to decorate, must not be null
     * @throws IllegalArgumentException if set or list is null
     */
//-----------------------------------------------------------------------
/**
     * Gets an unmodifiable view of the order of the Set.
     *
     * @return an unmodifiable list view
     */
//-----------------------------------------------------------------------
//-----------------------------------------------------------------------
/**
     * Uses the underlying List's toString so that order is achieved.
     * This means that the decorated Set's toString is not used, so
     * any custom toStrings will be ignored.
     */
// Fortunately List.toString and Set.toString look the same
//-----------------------------------------------------------------------
/**
     * Internal iterator handle remove.
     */
/** Object we iterate on */
/** Last object retrieved */
