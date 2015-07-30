/**
 * Decorates a set of other sets to provide a single unified view.
 * <p>
 * Changes made to this set will actually be made on the decorated set.
 * Add operations require the use of a pluggable strategy.
 * If no strategy is provided then add is unsupported.
 *
 * @since Commons Collections 3.0
 * @version $Revision: 966368 $ $Date: 2010-07-21 21:07:52 +0200 (Wed, 21 Jul 2010) $
 *
 * @author Brian McCallister
 */
/**
     * Create an empty CompositeSet
     */
/**
     * Create a CompositeSet with just <code>set</code> composited
     * @param set The initial set in the composite
     */
/**
     * Create a composite set with sets as the initial set of composited Sets
     */
/**
     * Add a Set to this composite
     *
     * @param c Must implement Set
     * @throws IllegalArgumentException if c does not implement java.util.Set
     *         or if a SetMutator is set, but fails to resolve a collision
     * @throws UnsupportedOperationException if there is no SetMutator set, or
     *         a CollectionMutator is set instead of a SetMutator
     * @see org.apache.commons.collections.collection.CompositeCollection.CollectionMutator
     * @see SetMutator
     */
/**
     * {@inheritDoc}
     */
/**
     * Add two sets to this composite
     *
     * @throws IllegalArgumentException if c or d does not implement java.util.Set
     */
/**
     * Add an array of sets to this composite
     * @param comps
     * @throws IllegalArgumentException if any of the collections in comps do not implement Set
     */
/**
     * This can receive either a <code>CompositeCollection.CollectionMutator</code>
     * or a <code>CompositeSet.SetMutator</code>. If a
     * <code>CompositeCollection.CollectionMutator</code> is used than conflicts when adding
     * composited sets will throw IllegalArgumentException
     * <p>
     */
/* Set operations */
/**
     * If a <code>CollectionMutator</code> is defined for this CompositeSet then this
     * method will be called anyway.
     *
     * @param obj Object to be removed
     * @return true if the object is removed, false otherwise
     */
/**
     * @see Set#equals
     */
/**
     * @see Set#hashCode
     */
/**
     * {@inheritDoc}
     */
/**
     * Define callbacks for mutation operations.
     * <p>
     * Defining remove() on implementations of SetMutator is pointless
     * as they are never called by CompositeSet.
     */
/**
         * <p>
         * Called when a Set is added to the CompositeSet and there is a
         * collision between existing and added sets.
         * </p>
         * <p>
         * If <code>added</code> and <code>existing</code> still have any intersects
         * after this method returns an IllegalArgumentException will be thrown.
         * </p>
         * @param comp The CompositeSet being modified
         * @param existing The Set already existing in the composite
         * @param added the Set being added to the composite
         * @param intersects the intersection of th existing and added sets
         */
